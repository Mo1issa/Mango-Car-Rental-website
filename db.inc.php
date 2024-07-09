<?php
define('DBHOST', 'localhost');
define('DBNAME', 'web_pr');
define('DBUSER', 'root');
define('DBPASS', '');
function db_connect($dbhost = DBHOST, $dbname = DBNAME , $username = DBUSER, $password = DBPASS){
    try {
  

        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;

    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>