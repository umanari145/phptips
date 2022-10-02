# phptips

PHPに関わる小ネタ

- Anonymous
    - call_user_func_array.php call_user_func_arrayを使ったリフレクション
    - call_user_func.php call_user_funcを使ったリフレクション
    - clouser.php  array_walkを使ったサンプル
    - clouser2.php 無名関数、array_map、array_filter、array_columnを使ったサンプル
    - clouser3.php array_reduceを使ったサンプル

- arrconvert
    - make_hash.php プルダウン系のデータを配列のPHPコードにする
    - hash_data.txt サンプルデータ

- cached
    - cached.php 静的キャッシュの使い方
    - redis.php redisを使ったキャッシュ

- class
    - SampleClass.php クラス変数とインスタンス変数の使い分け
    - SampleClass2.php マジックメソッド__callの使い方

- closure
    - array_convert.php clouserを使ったarray_mapの自作

- csv
    - dummy.php CSVのインポート＆エクスポート
    - load.csv CSVの読み込みとハッシュ化


- date/date.php dateTimeを使った日付の処理全般

- di Diのサンプル
    - type1
        - Dog.php メソッドインジェクション、セッタインジェクション、コンストラクタインジェクション
        - BuyFacade.php   DIを使わないサンプル(内部でクラスの作成)
        - BuyFacadeDI.php DIを使ったサンプル(createでの結合をする)
    - type2
        - DogIncIF.php IF(interface)ありのDogクラス
        - CatIncIF.php IF(interface)ありのCatクラス
        - PetInterface DogIncIFとCatIncIFのインターフェイス
        - Animal.php 注入される側(DIが使われてる側。ただしDIコンテナは使わない) 欠点としては具体的なクラスを記述する必要がある
        - AnimalUseDIContair.php 注入される側(DIコンテナ:Pimple使用 ) 利点としてはIF以下のクラスが見えなくても大丈夫(require_onceは覗く)
    - type3 DIコンテナをテスト用と本番用で手動で分ける(DIが一番効果を発揮する場面)
        - SendMailIF.php sendmail用のインターフェイス
        - SendMail.php sendmailプログラム(クラスがここで入っていないので依存性がない)
        - container.php DIコンテナ
        - ProdSendMail.php 本番用のsendmailプログラム
        - TestSendMail.php 開発用のsendmailプログラム


- error エラーハンドリング
    - errorCatch.php エラーハンドリングの具体例
    - exception.php 例外キャッチに関して
    - SentrySample.php エラーリポーティング(```https://sentry.io/settings/```でSENTRY_URLを取得)
    - CustomException.php 独自のException
    - MemberController.php ServiceのExceptionのキャッチ
    - MemberService.php 様々な例外のパターンを記述

- encoding 文字コードがらみ
    - mb_convert_encoding.php mb_convert_encodingの検出に関して
    - cp932_text.txt cp932で保存したファイル
    - utf8_text.txt utf8で保存したファイル

- filepointer ファイルポインタに関して
    - file_pointer.php ファイルポインタの検出に関して
    - sample_text.txt サンプルテキスト

- import インポート系のスクリプト(CSV→DBなど)に関して
    - make_update_sql.php update文作成
        ```
        ex.
        php make_update_sql.php -i"入力ファイル名" -o"出力ファイル名" -k"updateのkey" -t"テーブル名"
        ```
    - make_insert_sql.php insert文作成
        ```
        ex.
        php make_insert_sql.php -i"入力ファイル名" -o"出力ファイル名" -t"テーブル名"
        ```        
    - sample.csv サンプルCSV
- invoke
    - SampleClass.php invokeを内蔵したプログラム
    - yobidashi.php 呼び出し側のプログラム

- jwt JWT認証のサンプル (uml/jwt.pu jwtのシーケンス図)
  - login.php ログインの際にPOSTするプログラム
    ```
    curl -X POST http://localhost:8080/jwt/login.php \
    -H "Content-Type: application/json" \
    -d  '{"username": "sampleUser", "password": "samplePass"}'
    
    #tokenの発行
    {"token":"xxxxxxxx"}
    ```
  - data.php tokenを受け取り、実際にデータを返す部分
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
    - monolog.php モノログのサンプル 参考 https://gist.github.com/megatk/b7b7d9add34592d104a6  https://kzhishu.hatenablog.jp/entry/2015/10/04/200000
    - Log.php monologのラッパークラス
    - logCallSample.php ログを呼び出すサンプル

- last_static_binding 静的遅延束縛(selfとstatic)による違いなど
    - ParentClass.php 親クラス
    - ChildClass.php 子クラス 
    - start.php 実際のクラスを呼び出す場所

- mail メールのサンプル
    - sampleSendMail.php(phptips_php7コンテナの中に入って動かす)
    - http://localhost:8025/ でGUIツールにアクセス可能(実際にメールは送信されないでこのツールで仮想的に確認できる)
    - mailhog.pngはmailhogのスクショ
- memory_management メモリ管理(メモリ節約のパターン)　参考URL https://code-boxx.com/php-memory-management/
    - unset_pattern.php unsetのパターン　
- phpExcel PhpSpreadsheetを使ったサンプル
    - PHPExcel PHPからExcelの読み書きを行うことができる

- namespace namespaceを使ったサンプル
- oauth googleoauthを使った認証ロジック(uml/googleAuth.push参照)
    - cache テンプレートキャッシュディレクトリ
    - template　テンプレート(bladeを単独で使用)
        - login.blade.php ログインのテンプレート
    - public
        - login.js login時のJSの実装
    - index.php エントリーポイント(ログイン画面)
    - config.json googleアカウントなどの情報(clientIDなどの情報)
    - config.json.sample テンプレート 
    - home.php ログイン後の画面
    - loginCheck.php tokenの照合
    - logOut.php ログアウト時の処理
    - 参照リンク
        - https://qiita.com/biy0ganba/items/6c3a886759254e0e942c フロント側の実装
        - https://blog.4breaker.com/2020/06/03/post-1162/ フロント側の実装
        - https://developers.google.com/my-business/content/implement-oauth?hl=ja google公式
        - https://console.developers.google.com/apis/credentials 認証情報のgoogle画面
        - https://qiita.com/kmtym1998/items/768212fe92dbaa384c27 サーバーサイド側の実装
        - https://code.tutsplus.com/tutorials/create-a-google-login-page-in-php--cms-33214 サーバサイド側の実装

- pdflib pdfの活用   
    - pdfgenerateor.php fpdfを使ったサンプル
    - pdfgenerateor2.php tcpdfを使ったサンプル

- redis redisのサンプル
    - redisSample.php Redisのサンブル　Redisコマンド自体はredisコンテナの中でみる
    - http://localhost:8001/ でGUIツールにアクセス可能
    - redisinsigt.pngは接続時の情報

- reflection 動的クラスの作成
    - Animal.php 親クラス
    - Cat.php 子クラス1
    - Dog.php 子クラス2
    - ClassLoader.php autoloadの作成
    - reflection.php 実際の動的クラスの呼び出し

- request
    - curl.php curlコマンドでのPOST
    - file_get_contents_.php file_get_contentsを使ったPOST
    - #他にguzzleなどHTTPクライアントを使った方がいいかも。。。

- routing
    - Controller　コントーラー群
    - Service　サービス群
    - Model　モデル群
    - .htaccess htaccess(主にファイルがなかった時にindexを向かせる記述)
    - index.php 実際のルーティングの記述

- sendgrid 
    - sendgridを使ったメールサンプル
    
```
http://localhost:8080/routing/sampleAction→Controller/TopControllerのsampleActionにアクセス
参照リンク
https://www.codit.work/notes/30lgs07yv3ycwjpz6p8y/
```

- trait traitの活用(外部実装)
    - samplClass.php traitを受ける側の通常の野良クラス
    - sampleProgram.php sampleClassを呼び出して実行するクラス
    - sameplTrait.php Traitを実行するクラス

- underbar
    - scripts/summary.php underbar.phpを使ったサンプル

- util
    - makeModel.php getter-setterを記載するプログラム

- validation
    - laravelのvalidationライブラリ