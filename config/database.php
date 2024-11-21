<?php
try {
    $db = new PDO(
        "mysql:host=localhost;dbname=xsmida04;port=/var/run/mysql/mysql.sock",
        'xsmida04',
        'de4urpoj'
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}
return $db;
?>
