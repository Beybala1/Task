<?php

//get data from a table
function get($table): bool|array
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Secure form data
function csrf($input): string
{
    return isset($input) ? trim(htmlspecialchars($input)) : '';
}

//Insert data into a table
function insert($table, $data): string
{
    global $con;
    // Additional validation: Ensure all fields are filled
    foreach ($data as $value) {
        if (empty($value)) {
            return "Xanaları boş buraxmaq olmaz.";
        }
    }

    $tableRow = implode(', ', array_keys($data));
    $values = ':' . implode(', :', array_keys($data));

    $sql = "INSERT INTO $table ($tableRow) VALUES ($values)";
    $stmt = $con->prepare($sql);

    try {
        $stmt->execute($data);
        return "Məlumat uğurla daxil edildi";
    } catch (PDOException $e) {
        return "Xəta: " . $e->getMessage();
    }
}










