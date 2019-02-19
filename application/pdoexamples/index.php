<?php
$host = 'localhost';
$user = 'root';
$password = 'passwordforroot';
$dbname = 'demo';


$dsn = 'mysql:host='.$host.'dbname='.$dbname;

$pdo = new PDO($dsn, $user, $password);

$stmt = $pdo->query('SELECT * FROM MyGuests');

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    echo $row['firstname'].'<br>';
}