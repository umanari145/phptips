# phptips

PHP に関わる小ネタ
\*\* laravel の dd を採用("larapack/dd")

- Anonymous

  - call_user_func_array.php call_user_func_array を使ったリフレクション
  - call_user_func.php call_user_func を使ったリフレクション
  - clouser.php array_walk を使ったサンプル
  - clouser2.php 無名関数、array_map、array_filter、array_column を使ったサンプル
  - clouser3.php array_reduce を使ったサンプル

- arrconvert

  - make_hash.php プルダウン系のデータを配列の PHP コードにする
  - hash_data.txt サンプルデータ

- cached

  - cached.php 静的キャッシュの使い方
  - redis.php redis を使ったキャッシュ

- class

  - SampleClass.php クラス変数とインスタンス変数の使い分け
  - SampleClass2.php マジックメソッド\_\_call の使い方

- closure

  - array_convert.php clouser を使った array_map の自作

- collection

  - sample.php illuminate/collections をつかったサンプル

- csv

  - dummy.php CSV のインポート＆エクスポート
  - load.csv CSV の読み込みとハッシュ化

- date/date.php dateTime を使った日付の処理全般
- date/Carbon.php Carbon を使った日付の処理/Immutable についても

- di Di のサンプル

  - type1
    - Dog.php メソッドインジェクション、セッタインジェクション、コンストラクタインジェクション
    - BuyFacade.php DI を使わないサンプル(内部でクラスの作成)
    - BuyFacadeDI.php DI を使ったサンプル(create での結合をする)
  - type2
    - DogIncIF.php IF(interface)ありの Dog クラス
    - CatIncIF.php IF(interface)ありの Cat クラス
    - PetInterface DogIncIF と CatIncIF のインターフェイス
    - Animal.php 注入される側(DI が使われてる側。ただし DI コンテナは使わない) 欠点としては具体的なクラスを記述する必要がある
    - AnimalUseDIContair.php 注入される側(DI コンテナ:Pimple 使用 ) 利点としては IF 以下のクラスが見えなくても大丈夫(require_once は覗く)
  - type3 DI コンテナをテスト用と本番用で手動で分ける(DI が一番効果を発揮する場面)
    - SendMailIF.php sendmail 用のインターフェイス
    - SendMail.php sendmail プログラム(クラスがここで入っていないので依存性がない)
    - container.php DI コンテナ
    - ProdSendMail.php 本番用の sendmail プログラム
    - TestSendMail.php 開発用の sendmail プログラム

- error エラーハンドリング

  - errorCatch.php エラーハンドリングの具体例
  - exception.php 例外キャッチに関して
  - SentrySample.php エラーリポーティング(`https://sentry.io/settings/`で SENTRY_URL を取得)
  - CustomException.php 独自の Exception
  - MemberController.php Service の Exception のキャッチ
  - MemberService.php 様々な例外のパターンを記述

- encoding 文字コードがらみ

  - mb_convert_encoding.php mb_convert_encoding の検出に関して
  - cp932_text.txt cp932 で保存したファイル
  - utf8_text.txt utf8 で保存したファイル

- factory Factory パターンについてのサンプルコード

  - 参考 https://liginc.co.jp/web/programming/php/149051
  - AnimalController factory の呼び出し
  - AnimalFactory 実際の具体生成箇所(正しく factory)
  - Cat.php 具象クラス
  - Dog.php 具象クラス
  - Pet.php IF(Cat、Dog の上位)

- filepointer ファイルポインタに関して

  - file_pointer.php ファイルポインタの検出に関して
  - sample_text.txt サンプルテキスト

- import インポート系のスクリプト(CSV→DB など)に関して
  - make_update_sql.php update 文作成
    ```
    ex.
    php make_update_sql.php -i"入力ファイル名" -o"出力ファイル名" -k"updateのkey" -t"テーブル名"
    ```
  - make_insert_sql.php insert 文作成
    ```
    ex.
    php make_insert_sql.php -i"入力ファイル名" -o"出力ファイル名" -t"テーブル名"
    ```
  - sample.csv サンプル CSV
- invoke

  - SampleClass.php invoke を内蔵したプログラム
  - yobidashi.php 呼び出し側のプログラム

- jwt JWT 認証のサンプル (uml/jwt.pu jwt のシーケンス図)

  - login.php ログインの際に POST するプログラム

    ```
    curl -X POST http://localhost:8080/jwt/login.php \
    -H "Content-Type: application/json" \
    -d  '{"username": "sampleUser", "password": "samplePass"}'

    #tokenの発行
    {"token":"xxxxxxxx"}
    ```

  - data.php token を受け取り、実際にデータを返す部分

    ```
    curl -X GET http://localhost:8080/jwt/data.php \
    -H "Content-Type: application/json" \
    -H "Authorization: Bearer XXXXX(token文字列)"

    # user情報が出力されていればOK
    {"username":"sampleUser"}

    #こけたら下記のように出力される
     "Signature verification failed"
    ```

- logdir ログに関するテスト

  - monolog.php モノログのサンプル 参考 https://gist.github.com/megatk/b7b7d9add34592d104a6 https://kzhishu.hatenablog.jp/entry/2015/10/04/200000
  - Log.php monolog のラッパークラス
  - logCallSample.php ログを呼び出すサンプル

- last_static_binding 静的遅延束縛(self と static)による違いなど

  - ParentClass.php 親クラス
  - ChildClass.php 子クラス
  - start.php 実際のクラスを呼び出す場所

- mail メールのサンプル
  - sampleSendMail.php(phptips_php7 コンテナの中に入って動かす)
  - http://localhost:8025/ で GUI ツールにアクセス可能(実際にメールは送信されないでこのツールで仮想的に確認できる)
  - mailhog.png は mailhog のスクショ
- memory_management メモリ管理(メモリ節約のパターン)　参考 URL https://code-boxx.com/php-memory-management/
  - unset_pattern.php unset のパターン
- phpExcel PhpSpreadsheet を使ったサンプル

  - PHPExcel PHP から Excel の読み書きを行うことができる

- namespace namespace を使ったサンプル
- oauth googleoauth を使った認証ロジック(uml/googleAuth.push 参照)

  - cache テンプレートキャッシュディレクトリ
  - template 　テンプレート(blade を単独で使用)
    - login.blade.php ログインのテンプレート
  - public
    - login.js login 時の JS の実装
  - index.php エントリーポイント(ログイン画面)
  - config.json google アカウントなどの情報(clientID などの情報)
  - config.json.sample テンプレート
  - home.php ログイン後の画面
  - loginCheck.php token の照合
  - logOut.php ログアウト時の処理
  - 参照リンク
    - https://qiita.com/biy0ganba/items/6c3a886759254e0e942c フロント側の実装
    - https://blog.4breaker.com/2020/06/03/post-1162/ フロント側の実装
    - https://developers.google.com/my-business/content/implement-oauth?hl=ja google 公式
    - https://console.developers.google.com/apis/credentials 認証情報の google 画面
    - https://qiita.com/kmtym1998/items/768212fe92dbaa384c27 サーバーサイド側の実装
    - https://code.tutsplus.com/tutorials/create-a-google-login-page-in-php--cms-33214 サーバサイド側の実装

- pdflib pdf の活用

  - pdfgenerateor.php fpdf を使ったサンプル
  - pdfgenerateor2.php tcpdf を使ったサンプル

- php

  - tips PHP8 のネタ(名前付き引数、オブジェクトのプロモーション、null オペレーター)
  - operator 演算子について(三項演算子、エルビス演算子、null 演算子) https://www.asobou.co.jp/blog/web/php-operator

- redis redis のサンプル

  - redisSample.php Redis のサンブル　 Redis コマンド自体は redis コンテナの中でみる
  - http://localhost:8001/ で GUI ツールにアクセス可能
  - redisinsigt.png は接続時の情報

- reflection 動的クラスの作成

  - Animal.php 親クラス
  - Cat.php 子クラス 1
  - Dog.php 子クラス 2
  - ClassLoader.php autoload の作成
  - reflection.php 実際の動的クラスの呼び出し

- request

  - curl.php curl コマンドでの POST
  - file*get_contents*.php file_get_contents を使った POST
  - #他に guzzle など HTTP クライアントを使った方がいいかも。。。

- routing

  - Controller 　コントーラー群
  - Service 　サービス群
  - Model 　モデル群
  - .htaccess htaccess(主にファイルがなかった時に index を向かせる記述)
  - index.php 実際のルーティングの記述

- sendgrid

  - sendgrid を使ったメールサンプル

- scraping
  - scraping paquettg/php-html-parser による PHP スクレイピング

```
http://localhost:8080/routing/sampleAction→Controller/TopControllerのsampleActionにアクセス
参照リンク
https://www.codit.work/notes/30lgs07yv3ycwjpz6p8y/
```

- trait trait の活用(外部実装)

  - samplClass.php trait を受ける側の通常の野良クラス
  - sampleProgram.php sampleClass を呼び出して実行するクラス
  - sameplTrait.php Trait を実行するクラス

- underbar

  - scripts/summary.php underbar.php を使ったサンプル

- util

  - makeModel.php getter-setter を記載するプログラム

- validation
  - laravel の validation ライブラリ
