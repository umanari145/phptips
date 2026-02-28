<?php

/**
 * 排他制御なし（ロストアップデート発生）
 *
 * このプログラムは「商品の価格を1円ずつ加算する」処理。
 * 1回実行するたびに product_price が +1 されるはず。
 *
 * 【問題点】
 * SELECT してから UPDATE するまでの間にロックを取っていないため、
 * 複数プロセスが同時に実行されると、同じ値を読み取ってしまい、
 * 加算結果が上書きされて消える（＝ロストアップデート）。
 *
 * 【具体例】product_price が 0 の状態で、プロセスA と B が同時に動くと…
 *
 *   プロセスA: SELECT → 0 を取得
 *   プロセスB: SELECT → 0 を取得（Aがまだ UPDATE していないので 0 のまま）
 *   プロセスA: 0 + 1 = 1 で UPDATE
 *   プロセスB: 0 + 1 = 1 で UPDATE（本来 2 になるべきだが 1 で上書き）
 *
 *   → 2回実行したのに結果は 1。プロセスAの加算が消えた！
 *
 * 準備:
 *   UPDATE sample_table SET product_price = 0 WHERE id = 1;
 *
 * 実行例（手動で再現する方法）:
 *   1. ターミナルを2つ開く
 *   2. 両方のターミナルで素早く「php lock/no_lock.php」を実行する
 *   3. 3秒の待ち時間があるので、その間にもう一方も実行すれば間に合う
 *   4. 両方が同じ値を SELECT し、同じ値に UPDATE してしまうことを確認する
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
// ② 現在の product_price を DB から読み取る
//    ※ ここではロック（FOR UPDATE）を使っていないので、
//      他のプロセスも同時にこの値を読み取れてしまう
// -----------------------------------------
$stmt = $pdo->prepare('SELECT product_price FROM sample_table WHERE id = :id');
$stmt->execute([':id' => $id]);
$currentPrice = (int) $stmt->fetchColumn();
// fetchColumn() は SELECT 結果の最初の行・最初のカラムの値を返す
// ここでは product_price の値（例: 5）が文字列 "5" として返るので、
// (int) で整数にキャストして $currentPrice に代入する
// → DB の product_price が 5 なら $currentPrice = 5 が入る
echo "PID " . getmypid() . ": SELECTした値 = {$currentPrice}\n";

// -----------------------------------------
// ③ 実際の業務処理にかかる時間を再現するための待ち時間
//    （例: 在庫チェック、金額計算、外部APIの呼び出し など）
//    3秒間待つので、この間に別のターミナルから同じスクリプトを実行すると
//    同じ $currentPrice を読んでしまう → これが問題の原因
// -----------------------------------------
echo "PID " . getmypid() . ": 3秒間の業務処理中...（この間に別ターミナルで同じスクリプトを実行してください）\n";
sleep(3);

// -----------------------------------------
// ④ 読み取った値に +1 する
//    例: $currentPrice = 5 なら $newPrice = 6
//    しかし別のプロセスも $currentPrice = 5 を読んでいたら、
//    そちらも $newPrice = 6 を計算してしまう
// -----------------------------------------
$newPrice = $currentPrice + 1;

// -----------------------------------------
// ⑤ 計算結果を DB に書き戻す
//    例: product_price を 6 に UPDATE
//    別のプロセスも 6 を UPDATE → 本来 7 になるべきなのに 6 のまま
//    → これが「ロストアップデート（失われた更新）」
// -----------------------------------------
$stmt = $pdo->prepare('UPDATE sample_table SET product_price = :price WHERE id = :id');
$stmt->execute([':price' => $newPrice, ':id' => $id]);

echo "PID " . getmypid() . ": UPDATEした値 = {$newPrice} ({$currentPrice} → {$newPrice})\n";
