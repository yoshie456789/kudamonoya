<?php
include 'config.php';

$response = ['success' => false, 'message' => ''];

try {
    $pdo->beginTransaction();

    foreach($_POST['purchases'] as $purchase) {
        // 在庫を減少させる
        $sqlStock = "UPDATE products SET stock = stock - :quantity WHERE id = :productId";
        $stmtStock = $pdo->prepare($sqlStock);
        $stmtStock->bindParam(':quantity', $purchase['quantity'], PDO::PARAM_INT);
        $stmtStock->bindParam(':productId', $purchase['productId'], PDO::PARAM_INT);
        $stmtStock->execute();

        // purchasesテーブルにデータを挿入する
        $sqlPurchase = "INSERT INTO purchases (user_id, product_id, quantity, subtotal, subtotal_taxed) VALUES (1, :productId, :quantity, :subtotal, :subtotalTaxed)";
        $stmtPurchase = $pdo->prepare($sqlPurchase);
        $stmtPurchase->bindParam(':productId', $purchase['productId'], PDO::PARAM_INT);
        $stmtPurchase->bindParam(':quantity', $purchase['quantity'], PDO::PARAM_INT);
        $stmtPurchase->bindParam(':subtotal', $purchase['subtotal'], PDO::PARAM_STR);
        $stmtPurchase->bindParam(':subtotalTaxed', $purchase['subtotalTaxed'], PDO::PARAM_STR);
        $stmtPurchase->execute();
    }

    $pdo->commit();
    $response['success'] = true;
} catch (\PDOException $e) {
    $pdo->rollBack();
    $response['message'] = "データベースエラー: " . $e->getMessage();
}

echo json_encode($response);
?>
