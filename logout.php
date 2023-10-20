<?php
// セッションを開始
session_start();

// セッション変数を全て削除
$_SESSION = array();

// セッションを破棄
session_destroy();

// login.phpにリダイレクト
header('Location: login.php');
exit();
?>