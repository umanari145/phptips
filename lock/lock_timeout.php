<?php

/**
 * Lock wait timeout exceeded のサンプル
 *
 * プロセスAが行ロックを長時間保持し続けることで、
 * プロセスBがロック取得を待ちきれずタイムアウトエラーになる
 *
 * 【発生の仕組み】
 *   プロセスA: SELECT FOR UPDATE → ロック取得 → 30秒間 commit しない
 *   プロセスB: SELECT FOR UPDATE → ロック待ち → 5秒でタイムアウト
 *     → "Lock wait timeout exceeded; try restarting transaction" エラー
 *
 * 【実際の業務で起こるケース】
 *   - 重い処理をトランザクション内で実行してしまい、ロック保持時間が長くなる
 *   - commit/rollback を忘れてロックが解放されない
 *   - デバッグ中にトランザクションを開いたまま放置する
 *
 * 実行例（手動で再現する方法）:
 *   1. ターミナルを2つ開く
 *   2. ターミナル1: php lock/lock_timeout.php A
 *      → 「30秒間ロックを保持します」と表示される
 *   3. 5秒以内にターミナル2: php lock/lock_timeout.php B
 *      → 5秒後に「Lock wait timeout exceeded」エラーが発生する
 */

$mode = $argv[1] ?? 'A';

$pdo = new PDO(
    'mysql:host=db;dbname=phptips;charset=utf8mb4',
    'phptips_user',
    'phptips_password',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);

$id = 1;

if ($mode === 'A') {
    // -----------------------------------------
    // プロセスA: ロックを取得して長時間保持する側
    // -----------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = :id FOR UPDATE');
    $stmt->execute([':id' => $id]);
    $currentPrice = (int) $stmt->fetchColumn();

    echo "[プロセスA] ロック取得完了（product_price = {$currentPrice}）\n";
    echo "[プロセスA] 30秒間ロックを保持します...\n";
    echo "[プロセスA] この間に別ターミナルで「php lock/lock_timeout.php B」を実行してください\n";

    sleep(30);

    $pdo->commit();
    echo "[プロセスA] COMMIT してロックを解放しました\n";
} else {
    // -----------------------------------------
    // プロセスB: ロック取得を試みてタイムアウトする側
    // innodb_lock_wait_timeout を5秒に設定
    // （デフォルトは50秒だが、検証しやすいよう短くする）
    // -----------------------------------------
    $pdo->exec('SET innodb_lock_wait_timeout = 5');

    $pdo->beginTransaction();

    try {
        echo "[プロセスB] ロック取得を試みます...\n";
        echo "[プロセスB] プロセスAがロック中なので待機します（タイムアウト: 5秒）\n";

        $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = :id FOR UPDATE');
        $stmt->execute([':id' => $id]);

        // タイムアウトしなければここに到達する
        $currentPrice = (int) $stmt->fetchColumn();
        echo "[プロセスB] ロック取得成功（product_price = {$currentPrice}）\n";
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();

        // MySQL エラーコード 1205 = Lock wait timeout exceeded
        if ($e->errorInfo[1] === 1205) {
            echo "[プロセスB] *** Lock wait timeout exceeded ***\n";
            echo "[プロセスB] 5秒待ってもロックが解放されなかったため、タイムアウトしました\n";
            echo "[プロセスB] エラー: " . $e->getMessage() . "\n";
        } else {
            echo "[プロセスB] エラー: " . $e->getMessage() . "\n";
        }
    }
}
