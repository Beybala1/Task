<?php
require_once 'config/db.php';

$payment_type_id = $_POST['payment_type_id'] ?? null;
$currency_id = $_POST['currency_id'] ?? null;

$sql = "
    SELECT
        p.id,
        p.amount,
        pt.name AS payment_type_name,
        c.name AS currency_name,
        p.comment,
        p.income,
        p.expense,
        p.created_at
    FROM
        payment p
    INNER JOIN
        payment_type pt ON p.payment_type_id = pt.id
    INNER JOIN
        currency c ON p.currency_id = c.id
";

$whereConditions = [];

if ($payment_type_id !== null) {
    $whereConditions[] = "p.payment_type_id = :payment_type_id";
}

if ($currency_id !== null) {
    $whereConditions[] = "p.currency_id = :currency_id";
}

if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(" OR ", $whereConditions);
}

$stmt = $con->prepare($sql);

if ($payment_type_id !== null) {
    $stmt->bindParam(':payment_type_id', $payment_type_id, PDO::PARAM_INT);
}

if ($currency_id !== null) {
    $stmt->bindParam(':currency_id', $currency_id, PDO::PARAM_INT);
}

$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate HTML for the updated table rows
$html = '';
foreach ($payments as $payment) {
    $html .= '
    <tr>
        <th scope="row">' . $payment['id'] . '</th>
        <td>' . $payment['amount'] . '</td>
        <td>' . $payment['payment_type_name'] . '</td>
        <td>' . $payment['currency_name'] . '</td>
        <td>' . $payment['comment'] . '</td>
        <td>' . $payment['income'] . '</td>
        <td>' . $payment['expense'] . '</td>
        <td>' . ($payment['income'] - $payment['expense']) . '</td>
        <td>' . $payment['created_at'] . '</td>
    </tr>
    ';
}

echo $html;
?>
