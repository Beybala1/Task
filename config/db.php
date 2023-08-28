<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_db";

try {
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    $sql = "CREATE TABLE payment (
//        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//        amount FLOAT NOT NULL,
//        income FLOAT NOT NULL,
//        expense FLOAT NOT NULL,
//        currency_id INT(6) UNSIGNED NOT NULL,
//        payment_type_id INT(6) UNSIGNED NOT NULL,
//        comment TEXT,
//        FOREIGN KEY (payment_type_id) REFERENCES payment_type(id),
//        FOREIGN KEY (currency_id) REFERENCES currency(id),
//        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//    )";
//
//    $con->exec($sql);
//    echo "Table created successfully";

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

