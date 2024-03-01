<?php
// Standard Database Connection
$host = '127.0.0.1';
$db   = 'tresadb'; 
$pass = '';
$charset = 'utf8mb4';
$user = 'root';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
/* PDO (PHP Data Objects) is a code library for accessing databases
Advantages ->
            - Not specific to any database platform without having to learn new functions.
            - Named parameters in SQL Statements which means it is more secure, avoids injection attacks.
            - Take data from the database and input it directly into objects
            - Returns an array from the table in the database which makes the data easy to manipulate */
try 
{
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (\PDOException $e) 
{
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>