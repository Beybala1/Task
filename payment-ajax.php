<?php

require_once 'config/db.php';
require_once 'config/functions.php';

$amount = csrf($_POST['amount']);
$payment_type_id = csrf($_POST['payment_type_id']);
$currency_id = csrf($_POST['currency_id']);
$income = csrf($_POST['income']);
$expense = csrf($_POST['expense']);
$comment = csrf($_POST['comment']);

$payment = insert(
    'payment',
    [
        'amount' => $amount,
        'payment_type_id' => $payment_type_id,
        'currency_id' => $currency_id,
        'income' => $income,
        'expense' => $expense,
        'comment' => $comment,
    ],
);



