<?php

$dsn = "mysql:host=localhost;dbname=MyGuests";
$user = "root";
$passwd = "passwordforroot";

$pdo = new PDO($dsn, $user, $passwd);

$stm = $pdo->query("SELECT VERSION()");

$version = $stm->fetch();

echo $version[0] . PHP_EOL;
?>