<?php

/**
 * デッドロック発生サンプル
 *
 * 2つのプロセスが2つの行を逆順でロックしようとすることで
 * デッドロックが発生し、MySQL が一方のトランザクションを強制ロールバックする
 *
 * 準備:
 *   INSERT INTO sample_table(id, product_name, product_price) VALUES(2, 'bbbbb', 0)
 *     ON DUPLICATE KEY UPDATE product_name = 'bbbbb', product_price = 0;
 *   UPDATE sample_table SET product_price = 0 WHERE id = 1;
 *
 * 実行例:
 *   php lock/deadlock.php A &
 *   php lock/deadlock.php B &
 *   wait
 *   # → 一方のプロセスで "Deadlock found" エラーが発生する
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

// innodb_lock_wait_timeout を短く設定（デフォルト50秒は長いので）
$pdo->exec('SET innodb_lock_wait_timeout = 5');

$pdo->beginTransaction();

try {
    if ($mode === 'A') {
        // プロセスA: id=1 → id=2 の順でロック
        echo "[プロセスA] id=1 の行をロック中...\n";
        $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = 1 FOR UPDATE');
        $stmt->execute();
        echo "[プロセスA] id=1 のロック取得完了\n";

        sleep(3); // プロセスBがid=2をロックする時間を確保

        echo "[プロセスA] id=2 の行をロック中...(プロセスBが持っているのでブロック)\n";
        $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = 2 FOR UPDATE');
        $stmt->execute();
        echo "[プロセスA] id=2 のロック取得完了\n";
    } else {
        // プロセスB: id=2 → id=1 の順でロック（Aと逆順 → デッドロック）
        echo "[プロセスB] id=2 の行をロック中...\n";
        $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = 2 FOR UPDATE');
        $stmt->execute();
        echo "[プロセスB] id=2 のロック取得完了\n";

        sleep(3); // プロセスAがid=1をロックする時間を確保

        echo "[プロセスB] id=1 の行をロック中...(プロセスAが持っているのでブロック)\n";
        $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = 1 FOR UPDATE');
        $stmt->execute();
        echo "[プロセスB] id=1 のロック取得完了\n";
    }

    $pdo->commit();
    echo "[プロセス{$mode}] 正常完了\n";
} catch (PDOException $e) {
    $pdo->rollBack();

    // MySQL のデッドロックエラーコードは 1213
    if ($e->errorInfo[1] === 1213) {
        echo "[プロセス{$mode}] *** デッドロック検出 *** MySQL がこのトランザクションをロールバックしました\n";
        echo "[プロセス{$mode}] エラー: " . $e->getMessage() . "\n";
    } else {
        echo "[プロセス{$mode}] エラー: " . $e->getMessage() . "\n";
    }
}
