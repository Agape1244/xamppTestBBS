<?php

// **************************************
// データの書き込み処理
// **************************************
function post_data() {

    // データを一括読み込み
    $log_text = @file_get_contents("board.log");

    $json = json_decode( $log_text );
    // 空のファイルかまたは、JSON データでは無い場合
    if ( $json === null ) {

        // JSON 用クラス作成
        $json = new stdClass;
        // 行データを格納する配列を作成
        $json->item = array();

    }
//入力された記号をタグとして読み込まないための対策
    // 改行コードを \n のみ(1バイト)にする
    $_POST['text'] = str_replace("\r","",$_POST['text']);

    // HTML 要素を無効にする
    $_POST['text'] = str_replace("<","&lt;",$_POST['text']);
    $_POST['text'] = str_replace(">","&gt;",$_POST['text']);

    // HTML 要素を無効にする
    $_POST['subject'] = str_replace("<","&lt;",$_POST['subject']);
    $_POST['subject'] = str_replace(">","&gt;",$_POST['subject']);
    $_POST['handle'] = str_replace("<","&lt;",$_POST['handle']);
    $_POST['handle'] = str_replace(">","&gt;",$_POST['handle']);

    // 新しい投稿用のクラス作成
    $board_data = new stdClass;

    // text プロパティに 入力された本文をセット
    $board_data->text = $_POST['text'];
    // subject プロパティに 入力されたタイトルをセット
    $board_data->subject = $_POST['subject'];
    // name プロパティに 入力された名前をセット
    $board_data->name = $_POST['handle'];
    // subject プロパティに 入力されたタイトルをセット
    $board_data->datetime = $_POST['datetime'];

    // 配列の先頭に 新しい投稿データをセット
    array_unshift($json->item, $board_data);

    // 全ての投稿データを JSON として一括書き込み
    file_put_contents("./board.log", json_encode( $json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) );

    // GET メソッドで再表示します
    header( "Location: {$_SERVER["PHP_SELF"]}" );
    exit();


}

// **************************************
// データの表示処理
// **************************************
function disp_data() {

    // 埋め込み用データを global 宣言
    global $log_text;

    // データを一括読み込み
    $log_text = @file_get_contents("./board.log");
    // ファイルが存在しない場合
    if ( $log_text === false ) {
        $log_text = "ここに投稿データが表示されます";
        return;
    }

    $json = json_decode( $log_text );
    // 空のファイルかまたは、JSON データでは無い
    if ( $json === null ) {
        $log_text = "ここに投稿データが表示されます";
        return;
    }

    // 表示用の埋め込みに使用される文字列変数
    $log_text = "";
    foreach( $json->item as $v ) {

        // **************************************
        // 本文の改行は br 要素で表現します
        // **************************************
        $v->text = str_replace("\n", "<br>\n", $v->text );

        // **************************************
        // 記事の境界を hr 要素で表現します
        // **************************************
        $v->text .= "<hr>\n";

        // **************************************
        // 行毎に表示 HTML を作成
        // **************************************
        $log_text .= "【{$v->subject}】( {$v->name} : {$v->datetime} ) <br>" . $v->text;

    }


}

?>
