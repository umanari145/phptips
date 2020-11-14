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
        - Animal.php 注入される側(DIが使われてる側。ただしDIコンテナは使わない)
        - AnimalUseDIContair.php 注入される側(DIコンテナ:Pimple使用 )


- error エラーハンドリング
    - errorCatch.php エラーハンドリングの具体例
    - exception.php 例外キャッチに関して
    - SentrySample.php エラーリポーティング
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

- logdir ログに関するテスト

- namespace namespaceを使ったサンプル

- pdflib pdfの活用   
    - pdfgenerateor.php fpdfを使ったサンプル
    - pdfgenerateor2.php tcpdfを使ったサンプル

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

- trait traitの活用(外部実装)
    - samplClass.php traitを受ける側の通常の野良クラス
    - sampleProgram.php sampleClassを呼び出して実行するクラス
    - sameplTrait.php Traitを実行するクラス

- underbar
    - scripts/summary.php underbar.phpを使ったサンプル
