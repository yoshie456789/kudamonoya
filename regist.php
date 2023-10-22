<?php
session_start();
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (
    isset($_POST['username'], $_POST['password'], $_POST['name'], $_POST['phone'], $_POST['zip21'], $_POST['zip22'], $_POST['pref21'], $_POST['addr21'], $_POST['strt21'], $_POST['email'], $_POST['option'])
  ) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $zip21 = $_POST['zip21'];
    $zip22 = $_POST['zip22'];
    $pref21 = $_POST['pref21'];
    $addr21 = $_POST['addr21'];
    $strt21 = $_POST['strt21'];
    $email = $_POST['email'];
    $option_choice = $_POST['option'];
    $stmt = $pdo->prepare("INSERT INTO users (username, password, name, phone, zip21, zip22, pref21, addr21, strt21, email, option_choice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $password, $name, $phone, $zip21, $zip22, $pref21, $addr21, $strt21, $email, $option_choice]);

    // メール送信
    $to = $email;
    $subject = 'お申込みありがとうございます';
    $message = '申し込みを受け付けました。';
    $headers = 'From: yoshie456789@gmail.com' . "\r\n" .
      'Reply-To: yoshie456789@gmail.com' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
      echo '申し込みを受け付けました。メールが送信されました。';
    } else {
      echo 'メールの送信に失敗しました。';
    }

    header('Location: index.php');
    exit;
  } else {
    echo 'フォームデータが不完全です。';
  }
}

?>

<!DOCTYPE>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お申込みフォーム</title>
  <link rel="stylesheet" href="css/form.css">
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/valitation-test.js"></script>
  <script src="js/ajaxzip3.js"></script>
</head>

<body>

  <div class="container">
    <form action="regist.php" method="POST">
<!--
      <div class="midashi">
        <h3>登録情報</h3>
      </div>
-->
	<div class="midashi2">
<h3>登録情報</h3>
      <div class="main1">
        <label for="username">ユーザー名</label>
        <input type="text" name="username" placeholder="もも" autofocus required>
        <label for="password">パスワード</label>
        <input type="password" name="password" placeholder="半角英数字6文字" value="" required placeholder="半角英数字6文字"
          maxlength="6"><br><br><br>
        <label for="name">名前</label>
        <input type="text" class="name" name="name" placeholder="山田 太郎" autofocus required>
        <div class="nameError error-message"></div>
      </div>

      <div class="main1">
        <label for="tel">電話番号</label>
        <input type="tel" class="tell" name="phone" required pattern="\d{9,11}">
        <div class="telError error-message"></div>
      </div>

      <div class="main1">
        <label>郵便番号(3桁と4桁)</label>
        <div class="continer2">
          <input type="text" name="zip21" maxlength="3" placeholder="123" class="wi20 yuubin" required pattern="\d{3}">
          － <input type="text" name="zip22" maxlength="4" placeholder="4567" class="wi20 yuubin"
            onKeyUp="AjaxZip3.zip2addr('zip21','zip22','pref21','addr21','strt21');" required pattern="\d{4}">
        </div>
        <div class="addressError error-message"></div>
        <div>
          <label>都道府県</label>
          <input type="text" name="pref21" placeholder="愛知県">
        </div>
        <div>
          <label>市区町村</label>
          <input type="text" name="addr21" placeholder="名古屋市">
        </div>
        <div>
          <label>以降の住所</label>
          <input type="text" name="strt21" placeholder="〇〇">
        </div>
      </div>


      <div class="main1">
        <label for="email">メールアドレス</label>
        <input type="email" class="email" name="email" placeholder="usagisan@pyonpyon.com" required>
      </div>


      <!-- <div class="post main1" action="">
      <label for="input_color">認証コード</label><br>
      <input type="password" class="input_pass" name="input_pass" value="" required placeholder="半角英数字8~10文字" maxlength="10" >
    </div> -->

      <div class="main6">
        <div class="radio-group">
          <input type="radio" name="option" value="チラシ" class="mark">
          <label class="">チラシ</label>
        </div>

        <div class="radio-group">
          <input type="radio" name="option" value="HP" class="mark">
          <label>HP</label>
        </div>

        <div class="radio-group">
          <input type="radio" name="option" value="新聞・雑誌" class="mark">
          <label>新聞・雑誌</label>
        </div>

        <div class="radio-group">
          <input type="radio" name="option" value="お友達からの紹介" class="mark">
          <label>お友達からの紹介</label>
        </div>

        <div class="radio-group">
          <input type="radio" name="option" value="街で見かけた" class="mark">
          <label>街で見かけた</label>
        </div>
        <div class="radio-group">
          <input type="radio" name="option" value="SNSで知った" class="mark">
          <label>SNSで知った</label>
        </div>
      </div>

      <div class="wrapper">
        <div class="main5">
          <button type="submit" class="button">送信</button>
          <div class="passError error-message"></div>
        </div>
      </div>
  </div>
    </form>

</body>

</html>