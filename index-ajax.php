<?php

require_once 'config/db.php';
require_once('config/functions.php');

$name = csrf($_POST['name']);

$payment_type = insert(
    'payment_type',
    [
        'name' => $name,
    ],
);


