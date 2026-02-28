<?php

/**
 * SELECT ... FOR UPDATE による排他制御あり
 *
 * このプログラムは no_lock.php と同じ「商品の価格を1円ずつ加算する」処理。
 * 違いは SELECT に FOR UPDATE を付けてトランザクション内で実行している点。
 *
 * 【排他制御の仕組み】
 * FOR UPDATE を付けると、SELECT した行に「排他ロック」がかかる。
 * ロックがかかっている間、別のトランザクションが同じ行を FOR UPDATE で
 * SELECT しようとすると、ロックが解放される（commit/rollback）まで待たされる。
 *
 * 【具体例】product_price が 0 の状態で、ターミナルA と B で同時に実行すると…
 *
 *   ターミナルA: SELECT FOR UPDATE → 0 を取得 & ロック取得
 *   ターミナルB: SELECT FOR UPDATE → ロック待ち（Aが持っているので止まる）
 *   ターミナルA: 0 + 1 = 1 で UPDATE → COMMIT → ロック解放
 *   ターミナルB: ロック取得 → 1 を取得（Aの更新後の最新値）
 *   ターミナルB: 1 + 1 = 2 で UPDATE → COMMIT
 *
 *   → 結果は正しく 2 になる！
 *
 * 【no_lock.php との違い】
 *   no_lock.php  : beginTransaction なし / SELECT（ロックなし）
 *   with_lock.php: beginTransaction あり / SELECT ... FOR UPDATE（排他ロック）
 *   この2点だけの違いで、結果の正確性が変わる
 *
 * 準備:
 *   UPDATE sample_table SET product_price = 0 WHERE id = 1;
 *
 * 実行例（手動で再現する方法）:
 *   1. ターミナルを2つ開く
 *   2. 1つ目のターミナルで「php lock/with_lock.php」を実行
 *   3. 3秒の待ち時間中に、2つ目のターミナルで「php lock/with_lock.php」を実行
 *   4. 2つ目はSELECTの時点で止まり、1つ目が完了してから動き出すことを確認する
 */

// -----------------------------------------
// ① DB に接続する
// -----------------------------------------
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

// -----------------------------------------
// ② トランザクションを開始する
//    FOR UPDATE によるロックはトランザクション内でのみ有効
//    commit() または rollBack() でロックが解放される
// -----------------------------------------
$pdo->beginTransaction();

try {
    // -----------------------------------------
    // ③ FOR UPDATE で対象行の排他ロックを取得しつつ値を読み取る
    //    別のプロセスがこの行をロック中の場合、ここで待機する
    //    （no_lock.php では FOR UPDATE がないので待機せず素通りする）
    // -----------------------------------------
    $stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = :id FOR UPDATE');
    $stmt->execute([':id' => $id]);
    $currentPrice = (int) $stmt->fetchColumn();
    echo "PID " . getmypid() . ": SELECTした値 = {$currentPrice}\n";

    // -----------------------------------------
    // ④ 業務処理を想定した遅延（3秒間ロックを保持する）
    //    この間、別ターミナルで実行すると③の時点で止まる
    //    no_lock.php では止まらず同じ値を読んでしまうのとの違いに注目
    // -----------------------------------------
    echo "PID " . getmypid() . ": 3秒間の業務処理中...（この間、別ターミナルで実行すると待機させられます）\n";
    sleep(3);

    // -----------------------------------------
    // ⑤ 読み取った値に +1 する
    //    ロックにより他プロセスは待機中なので、安全に計算できる
    // -----------------------------------------
    $newPrice = $currentPrice + 1;

    $stmt = $pdo->prepare('UPDATE sample_table SET product_price = :price WHERE id = :id');
    $stmt->execute([':price' => $newPrice, ':id' => $id]);

    // -----------------------------------------
    // ⑥ COMMIT してロックを解放する
    //    この瞬間、③で待機していた別プロセスが動き出し、
    //    更新後の最新値を読み取る
    // -----------------------------------------
    $pdo->commit();

    echo "PID " . getmypid() . ": UPDATEした値 = {$newPrice} ({$currentPrice} → {$newPrice})\n";
} catch (Exception $e) {
    // エラー時はロールバックしてロックを解放する
    $pdo->rollBack();
    echo "PID " . getmypid() . ": エラー発生 - " . $e->getMessage() . "\n";
}
