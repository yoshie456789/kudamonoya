<?php
include 'config.php';

$db = new mysqli('localhost', 'root', 'root', 'kudamonoshop');
if ($db->connect_error) {
    die("データベースへの接続エラー: " . $db->connect_error);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理画面</title>
    <link rel="stylesheet" href="css/kanri.css">
    <script>
function readURL(input, imgElement) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            imgElement.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</head>

<body>
    <div class="header">商品管理画面</div>
    <div class="nyuryoku">
    <form action="process.php" method="post" enctype="multipart/form-data">
        <input type="text" name="product_name" placeholder="商品名">
        <input type="number" name="stock_quantity" placeholder="在庫数">
        <input type="number" name="price" placeholder="商品価格">
        <input type="file" name="image" accept="image/*">
        <input type="submit" name="add_product" value="追加">
    </form>
    </div>

<div class="container">
<table>
<thead>
    <tr>
        <td>No</td>
        <td>商品名</td>
        <td>在庫数</td>
        <td>商品価格</td>
        <td>イメージ画像</td>
        <td>削除</td>
        <td>更新</td>
    </tr>
</thead>
<tbody>

<?php
// データベースから商品情報を取得するコードを実装
$query = "SELECT * FROM products WHERE is_deleted = 0";
$result = $db->query($query);
if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
    echo "<form action='process.php' method='post' enctype='multipart/form-data'>";
        echo "<td>" . $counter . "</td>";
        echo "<td><input type='text' name='product_name[" . $row['id'] . "]' value='" . $row['product_name'] . "'></td>";
        echo "<td><input type='text' name='stock_quantity[" . $row['id'] . "]' value='" . $row['stock'] . "'></td>";
        echo "<td><input type='text' name='price[" . $row['id'] . "]' value='" . $row['price'] . "'></td>";
        echo "<td><input type='file' name='image[" . $row['id'] . "]' accept='image/*' onchange='readURL(this, this.nextElementSibling);'><img src='img/" . $row['image'] . "' alt='イメージ画像' style='max-width: 100px;'></td>";
        echo "<td><input type='hidden' name='product_id' value='" . $row['id'] . "'><input type='submit' name='delete_product' value='削除'></td>";
        echo "<td><input type='submit' name='update_product' value='更新'></td>";
        echo "</tr>";
        echo "</form>";
        $counter++;
    }
} else {
    echo "<tr><td colspan='6'>商品情報はありません。</td></tr>";
}
// 在庫の更新
if (isset($_POST['update_table'])) {
    foreach ($_POST['product_name'] as $id => $name) {
        $stock = $_POST['new_stock_quantity'][$id];
        $price = $_POST['price'][$id];
        $image = $_POST['image'][$id];

        $query = "UPDATE products SET product_name = :name, stock = :stock, price = :price, image = :image WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
// 商品の削除
if (isset($_POST['delete_product'])) {
    $delete_id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$delete_id]);
    if ($stmt->error) {
        die("SQL error: " . $stmt->error);
    }
}

?>
    </tbody>
    </table>  
    </div>
</body>

</html>
<?php
$db->close();
?>