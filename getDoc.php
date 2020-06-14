<?php
/*
    echo('<h1>Hello</h1>');
    phpinfo();
 */


    $host='127.0.0.1';
    $user='web';
    $db='freeDocs';
    $password='scsi_derik81';
    $charset='utf8';

    dddd

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $password, $opt);
    } catch (PDOException $e) {
        die('Неможливо підєднатися до бази даних' . $e->GETmESSAGE());
    }

    $stmt=$pdo->query('select title from docs');
    while($row=$stmt->fetch())
    {
        echo $row['title'] . "<br>";
    }

    function getDocumentsByUpdateDate(string $date):array
    {


    }


?>