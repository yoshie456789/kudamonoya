<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';

// ユーザーIDの取得
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];

// POSTデータを受け取る
$quantities = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'quantity_') === 0) {
        $productId = str_replace('quantity_', '', $key);
        $quantities[$productId] = is_numeric($value) ? intval($value) : 0;
    }
}
$total = 0;
foreach ($quantities as $productId => $quantity) {
    if ($quantity <= 0) {
        continue;  // この商品の処理をスキップ
    }

    $sql = "SELECT price, stock FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        die("商品ID {$productId} の情報を取得できませんでした.");
    }
    
    $price = $product['price'];
    $subtotal = $price * $quantity;
    $subtotalWithTax = $subtotal * 1.08;

    // 購入情報をpurchasesテーブルに保存
    $insertSQL = "INSERT INTO purchases (user_id, product_id, quantity, subtotal, subtotal_taxed) VALUES (:userId, :productId, :quantity, :subtotal, :subtotalWithTax)";
    $insertStmt = $pdo->prepare($insertSQL);
    $insertStmt->bindParam(':userId', $user_id, PDO::PARAM_INT);  // ここで修正
    $insertStmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $insertStmt->bindParam(':subtotal', $subtotal);
    $insertStmt->bindParam(':subtotalWithTax', $subtotalWithTax);
    if (!$insertStmt->execute()) {
        die("購入情報の保存に失敗しました.");
    }

    // 在庫の更新
    $current_stock = $product['stock'];
    $new_stock = $current_stock - $quantity;
    $updateStockStmt = $pdo->prepare("UPDATE products SET stock = :new_stock WHERE id = :product_id");
    $updateStockStmt->execute(['new_stock' => $new_stock, 'product_id' => $productId]);
$total += $subtotal;
var_dump($_POST);
}

$totalWithTax = $total * 1.08;
$purchasedProducts = [];  // 購入された商品の情報を保存する配列

foreach ($quantities as $productId => $quantity) {
    // ...（他のコード）

    $purchasedProducts[] = [
        'product_id' => $productId,
        'quantity' => $quantity,
        'product_name' => $product['product_name'],
        'price' => $product['price']
    ];
}

// 購入された商品の情報をセッションに保存
$_SESSION['purchased_products'] = $purchasedProducts;

header('Location: kanryou.php');
exit;
?>
