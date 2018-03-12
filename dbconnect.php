<?php 
    $dsn = 'mysql:dbname=teamcharlotte;host=localhost';
    $db_user = 'root';
    $db_password='';
    $dbh = new PDO($dsn, $db_user, $db_password);
    $dbh->query('SET NAMES utf8');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 ?>