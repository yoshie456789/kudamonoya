<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    // セッションが設定されていない場合、ログインページにリダイレクト
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // セッションや何かからユーザーIDを取得する必要があります。

// データベースからデータを取得
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $zip21 = $_POST['zip21'];
    $zip22 = $_POST['zip22'];
    $pref21 = $_POST['pref21'];
    $addr21 = $_POST['addr21'];
    $strt21 = $_POST['strt21'];
    $email = $_POST['email'];

    // データベースのデータを更新
    $stmt = $pdo->prepare("UPDATE users SET username = ?, name = ?, phone = ?, zip21 = ?, zip22 = ?, pref21 = ?, addr21 = ?, strt21 = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $name, $phone, $zip21, $zip22, $pref21, $addr21, $strt21, $email, $user_id]);

    echo 'プロフィールが更新されました。';
}

$message = ''; // メッセージを初期化

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... 保存処理 ...

    if ($stmt->rowCount()) { // 更新された行があるかどうかを確認
        $message = 'プロフィールが更新されました。';
    } else {
        $message = '変更が反映されませんでした。再試行してください。';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報変更ページ</title>
    <link rel="stylesheet" href="css/form.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/valitation-test.js"></script>
    <script src="js/ajaxzip3.js"></script>
	<script>
$(document).ready(function(){
    $(".btn-gNav").on("click", function(){
        $(this).toggleClass("open");
        $(".gNav").toggleClass("open");
    });
});
</script>

</head>

<body>
	<div class="midashi2">
		<h3>登録情報編集ページ</h3>
        <form action="edit_profile.php" method="POST">
            <label for="username">ユーザー名</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <label for="name">名前</label>
            <input type="text" class="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" autofocus
                required>

            <div class="main1">
                <label for="tel">電話番号</label>
                <input type="tel" class="tell" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                    required pattern="\d{9,11}">
            </div>

            <div class="main1">
                <label>郵便番号(3桁と4桁)</label>
                <div class="continer2">
                    <input type="text" name="zip21" maxlength="3"
                        value="<?php echo htmlspecialchars($user['zip21']); ?>" class="wi20 yuubin" required
                        pattern="\d{3}"> － <input type="text" name="zip22" maxlength="4"
                        value="<?php echo htmlspecialchars($user['zip22']); ?>" class="wi20 yuubin"
                        onKeyUp="AjaxZip3.zip2addr('zip21','zip22','pref21','addr21','strt21');" required
                        pattern="\d{4}">
                </div>
                <div class="addressError error-message"></div>
                <div>
                    <label>都道府県</label>
                    <input type="text" name="pref21" value="<?php echo htmlspecialchars($user['pref21']); ?>">
                </div>
                <div>
                    <label>市区町村</label>
                    <input type="text" name="addr21" value="<?php echo htmlspecialchars($user['addr21']); ?>">
                </div>
                <div>
                    <label>以降の住所</label>
                    <input type="text" name="strt21" value="<?php echo htmlspecialchars($user['strt21']); ?>">
                </div>
            </div>
            <div class="main1">
                <label for="email">メールアドレス</label>
                <input type="email" class="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="wrapper">
                <div class="main5">
                    <button type="submit"  class="button">変更</button>
                </div>
            </div>

            <?php if (!empty($message)): ?>
                <div class="message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
			    </div>
        </form>
        <div class="buttons-container">
        <a href="index.php" class="button">トップページ</a>
        <a href="logout.php" class="button">ログアウト</a>
    </div>	
	<div class="hamburger">
        <div class="logo"></div>
        <p class="btn-gNav">
            <span></span>
            <span></span>
            <span></span>
        </p>
        <nav class="gNav">
            <ul class="gNav-menu">
                <li><a href="index.php" class="button">トップページ</a></li>
                <li><a href="logout.php" class="button">ログアウト</a></li>
            </ul>
        </nav>
    </div>   
</body>

</html>