<?php
session_start();
include 'config.php';

$purchasedProducts = $_SESSION['purchased_products'];

$grandTotal = 0;
$grandTotalTaxed = 0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入確認</title>
    <link rel="stylesheet" href="css/kanryou.css">
</head>
<body>
<div class="buttons-container">
        <a href="index.php" class="button">トップページ</a>
        <a href="logout.php" class="button">ログアウト</a>
    </div>

<div class="h3">購入確認</div>

<p class ="main">
    <?php 
    if(isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $query = "SELECT name FROM users WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user) {
            $_SESSION['name'] = $user['name']; // セッションにユーザー名を保存
        } else {
            die("ユーザー情報の取得に失敗しました。");
        }
    }
    echo htmlspecialchars($_SESSION['name']); // セッションからユーザーの名前を取得 ?> 様<br>

    <?php 
    foreach ($purchasedProducts as $product) {
        // このIDと数量を使って、購入された商品の詳細情報をデータベースから取得します。
        $query = "
        SELECT 
            p.product_name AS 'Purchased Product',
            p.price AS 'Unit Price',
            (? * p.price) AS 'Total Subtotal',
            (? * p.price * 1.08) AS 'Total Subtotal Taxed'
        FROM 
            products p
        WHERE 
            p.id = ?
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$product['quantity'], $product['quantity'], $product['product_id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo htmlspecialchars($result['Purchased Product']) . " (" . htmlspecialchars($product['quantity']) . "個)<br>";
        echo "単価: " . htmlspecialchars($result['Unit Price']) . "円<br>";
        echo "小計: " . htmlspecialchars(round((float) $result['Total Subtotal'])) . "円<br>";

        // 各商品の合計を総合計に追加
        $grandTotal += (float) $result['Total Subtotal'];
        $grandTotalTaxed += (float) $result['Total Subtotal Taxed'];
    }
    ?>

    <br>
    合計金額: <?php echo htmlspecialchars(round($grandTotal)); ?>円<br>
    総合計（税込）: <?php echo htmlspecialchars(round($grandTotalTaxed)); ?>円<br>

    準備出来次第配送させていただきます。
</p>

</body>
</html>
