<?php
session_start();
include 'config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// データを取得するSQLクエリ
$sql = "SELECT * FROM products";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
    // ここで$productsを利用してデータを処理することができます
} catch (\PDOException $e) {
    die("データベースクエリエラー: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>こだわり果物店</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/index.js"></script>
</head>
<body>
<div class="buttons-container">
    <a href="edit_profile.php" class="button">プロフィール編集</a>
    <a href="logout.php" class="button">ログアウト</a>
</div>
    <div class="waku"></div>
    <div class="header">
        fruit shop
    </div>   
<?php
echo '<form action="process_order.php" method="post">';
echo '<div class="continer">';

foreach($products as $row) {
    echo '<div class="item" data-product-id="' . $row["id"] . '">';
    echo '<img src="img/' . $row["image"] . '" class="fruit-image">';
    echo '<div class="product_name">' . $row["product_name"] . '</div>';
    echo '<div class="cont2"><span class="price1" id="price_' . $row["id"] . '">' . $row["price"] . '</span>円</div>';
    echo '<div class="cont2">残り<span id="stock_' . $row["id"] . '" data-original-stock="' . $row["stock"] . '">' . $row["stock"] . '</span>個</div>';
    echo '<div class="cont2"><input type="number" name="quantity_' . $row["id"] . '" id="inputText_' . $row["id"] . '" data-product-id="' . $row["id"] . '"> <span class="inputNumber"></span>個</div>';
    echo '<div class="cont2"><span class="result" id="result_' . $row["id"] . '"></span></div>';
    echo '<div class="cont2">消費税込み<span class="result2" id="result2_' . $row["id"] . '"></span></div></br>';
    echo '</div>';  // 商品の情報を囲む div を閉じる
}

echo '</div>';  // continer を閉じる
echo '<div class="center-wrapper">';
    echo '<div class="totals">';
    echo '</br><div class="cont2">合計：<span id="grandtotal"></span></div>';
    echo '<div class="cont2">消費税込み：<span id="grandtotaltax"></span></div>';    
        echo '<div class="cont2"><input type="submit" value="購入" class="grandTotalSubmit"></div></br>';
    echo '</div>';
echo '</div>';
echo '</form>';
?>
    </div>
</body>
</html>
