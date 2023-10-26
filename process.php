<?php

include 'config.php';

$db = new PDO($dsn, $user, $pass, $options);

if (isset($_POST['add_product'])) {
    $productName = $_POST['product_name'];
    $productStock = $_POST['stock_quantity'];
    $productPrice = $_POST['price'];

    $imageDir = "img/";
    $imageName = $_FILES['image']['name'];
    $imagePath = $imageDir . basename($imageName);

    if(!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        die("ファイルの移動に失敗しました");
    }

    $stmt = $db->prepare("INSERT INTO products (product_name, stock, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$productName, $productStock, $productPrice, $imageName]);
}

// 在庫の更新
if (isset($_POST['update_product'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'][$productId];
    $productStock = $_POST['stock_quantity'][$productId];
    $productPrice = $_POST['price'][$productId];

    // 画像がアップロードされているかどうかをチェック
    if(!empty($_FILES['image']['name'][$productId])) {
        $imageDir = "img/";
        $imageName = $_FILES['image']['name'][$productId];
        $imagePath = $imageDir . basename($imageName);
        
        if (!is_writable($imageDir)) {
            die("imgディレクトリに書き込み権限がありません。");
        }
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'][$productId], $imagePath)) {
            die("ファイルの移動に失敗しました");
        }

    } else {
        // 画像がアップロードされていない場合、元の画像ファイル名をそのまま使用
        $currentData = $db->prepare("SELECT image FROM products WHERE id = :id");
        $currentData->bindParam(':id', $productId, PDO::PARAM_INT);
        $currentData->execute();
        $result = $currentData->fetch(PDO::FETCH_ASSOC);
        $imageName = $result['image'];
    }

    $query = "UPDATE products SET product_name = :name, stock = :stock, price = :price, image = :image WHERE id = :id";  // この行を修正
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $productName);
    $stmt->bindParam(':stock', $productStock, PDO::PARAM_INT);
    $stmt->bindParam(':price', $productPrice, PDO::PARAM_INT);
    $stmt->bindParam(':image', $imageName);  // この行を修正
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    
    if(!$stmt->execute()) {
        echo "更新に失敗しました: " . implode(", ", $stmt->errorInfo());
        exit;
    } else {
        header("Location: kanri.php");
        exit();
    }
}

// 商品の削除
if (isset($_POST['delete_product'])) {
    $delete_id = $_POST['product_id'];
    $stmt = $db->prepare("UPDATE products SET is_deleted = 1 WHERE id = ?");
    $stmt->execute([$delete_id]);
}

header("Location: kanri.php");
exit();
?>
