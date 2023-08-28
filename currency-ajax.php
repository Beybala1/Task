<?php

require_once 'config/db.php';
require_once('config/functions.php');

$name = csrf($_POST['name']);

$currency = insert(
    'currency',
    [
        'name' => $name,
    ],
);


