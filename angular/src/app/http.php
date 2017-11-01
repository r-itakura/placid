<?php

$n = $_GET['name'];
if (empty($n)) {
    // 名前が未入力の場合はサーバーエラーを応答
    header('HTTP/1.1 500 Internal Server Error');
} else {
    // 挨拶メッセージを応答
    print('こんにちは'.$n.'さん');
}