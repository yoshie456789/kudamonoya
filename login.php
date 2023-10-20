<?php
include 'config.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/login.css">
  <title>ログインページ</title>
</head>

<body>
  <div class="main"> 
  <form method="post">
  <div class="form1">
    <p class="sign" align="center">ログインページ</p>
      <input class="un" type="text"  name="username" align="center" placeholder="ユーザー名">
      <input class="pass" type="password"  name="password" align="center" placeholder="パスワード(英数字6桁)">
      <div class="wrapper">
      <button type="submit">ログイン</button>
      <p>会員でない方は<a href="regist.php">こちら</a></p>
      </div>
      </div> 
</form>                
</div>     
</body>
</html>

<!-- <form method="post">
    ユーザー名: <input type="text" name="username">
    パスワード: <input type="password" name="password">
    <button type="submit">ログイン</button>
</form>
<p>会員でない方は<a href="regist.php">こちら</a></p> -->