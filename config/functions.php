<?php

//Get absolute path of the current working directory
function asset($path): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . '://' . $host . '/' . ltrim($path, '/');
}

//Count the number of rows in a table
function count_($table): void
{
    global $con;
    $query = "SELECT COUNT(*) FROM $table";

    // Prepare and execute the query
    $stmt = $con->prepare($query);
    $stmt->execute();

    // Fetch the result
    $row_count = $stmt->fetchColumn();
    echo $row_count;
}

function get($table): bool|array
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Secure form data
function csrf($input) {
    return isset($input) ? trim(htmlspecialchars($input)) : '';
}

//Insert data into a table

function insert($table, $data): string
{
    // Additional validation: Ensure all fields are filled
    global $con;

//    // Additional validation: Ensure all fields are filled
//    foreach ($data as $field => $value) {
//        if (empty($value)) {
//            return "All fields are required.";
//        }
//    }

    // Prepare and execute the SQL query
    $tableRow = implode(', ', array_keys($data));
    $values = ':' . implode(', :', array_keys($data));

    $sql = "INSERT INTO $table ($tableRow) VALUES ($values)";
    $stmt = $con->prepare($sql);

    try {
        $stmt->execute($data);
        return "Məlumat uğurla daxil edildi";
    } catch (PDOException $e) {
        return "Error inserting data: " . $e->getMessage();
    }
}










