<?php

$dsn = 'mysql:host=172.30.203.154, 1433;dbname=SCADA';
$username = 'opds1';
$password = '10514A#983*b';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $dbh = new PDO($dsn, $username, $password, $options);
    echo 'Connection established.<br />';
} catch (PDOException $e) {
    echo 'Connection could not be established.<br />'.$e->getMessage();
}
