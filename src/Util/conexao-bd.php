<?php
    $dbname = 'web_loja_de_roupas';
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpassword = 'root';

    $pdo = new PDO(
        'mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8mb4', $dbuser, $dbpassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

?>
