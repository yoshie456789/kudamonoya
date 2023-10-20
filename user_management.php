<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php';

// 上記のSQLクエリを実行してデータを取得
$query = "
SELECT 
    u.name AS 'Customer Name',
    p.product_name AS 'Purchased Product',
    pu.quantity AS 'Quantity Purchased',
    pu.purchase_date AS 'Purchase Date',
    CONCAT(u.zip21, ' - ', u.zip22) AS 'Postal Code',
    CONCAT(u.pref21, ' ', u.addr21, ' ', u.strt21) AS 'Address',
    u.email AS 'Email',
    SUM(pu.subtotal) AS 'Total Subtotal',
    (SUM(pu.subtotal) * 1.08) AS 'Total Subtotal Taxed'
FROM 
    purchases pu
JOIN users u ON pu.user_id = u.id
JOIN products p ON pu.product_id = p.id
GROUP BY pu.purchase_date, u.id, p.product_name, pu.quantity
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$groupedData = [];

foreach ($results as $row) {
    $key = $row['Purchase Date'] . '-' . $row['Customer Name'];  // ここで購入日時と顧客名をキーとして連結

    if (!isset($groupedData[$key])) {
        $groupedData[$key] = [
            'Customer Name' => $row['Customer Name'],
            'Email' => $row['Email'],
            'Purchase Date' => $row['Purchase Date'],
            'Postal Code' => $row['Postal Code'],
            'Address' => $row['Address'],
            'Total Subtotal' => 0, // 初期値0に設定
            'Total Subtotal Taxed' => 0, // 初期値0に設定
            'Products' => []
        ];
    }

    $groupedData[$key]['Products'][] = [
        'Purchased Product' => $row['Purchased Product'],
        'Quantity Purchased' => $row['Quantity Purchased'],
    ];

    // subtotalとsubtotal_taxedを累計
    $groupedData[$key]['Total Subtotal'] += (float) $row['Total Subtotal'];
$groupedData[$key]['Total Subtotal Taxed'] += (float) $row['Total Subtotal Taxed'];

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客の購入情報</title>
    <link rel="stylesheet" href="css/kanri.css">
</head>
<body>
<div class="header">顧客の購入情報</div>
<div class="container">
<table border="1">
    <thead>
        <tr>
        <th>顧客名</th>
            
            <th>購入した商品と数量</th>
            <th>購入日</th>
            <th>郵便番号〒</th>
            <th>住所</th>
            <th>総合計</th>
            <th>総合計 (税込)</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($groupedData as $row): ?>
        <tr>
        <td><?php echo htmlspecialchars($row['Customer Name']); ?></td>
            <td>
                <?php foreach ($row['Products'] as $product): ?>
                    <?php echo htmlspecialchars($product['Purchased Product']); ?> (<?php echo htmlspecialchars($product['Quantity Purchased']); ?>個)<br>
                <?php endforeach; ?>
            </td>
            <td><?php echo htmlspecialchars($row['Purchase Date']); ?></td>
            <td><?php echo htmlspecialchars($row['Postal Code']); ?></td>
            <td><?php echo htmlspecialchars($row['Address']); ?></td>
            <td><?php echo htmlspecialchars(round((float) $row['Total Subtotal'])); ?>円</td>
<td><?php echo htmlspecialchars(round((float) $row['Total Subtotal Taxed'])); ?>円</td>
<td><?php echo htmlspecialchars($row['Email']); ?></td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</body>
</html>