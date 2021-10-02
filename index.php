<?php 
    require_once "class/Connection/Connection.php";

    $connection = new Connection;

/*
    $query = "INSERT INTO `users` (`name`, `lastname`) VALUES ('22', '22')";
    print_r($connection->nonQueryId($query));

    $query = "SELECT * FROM apirest.users";

    print_r($connection->getData($query));
*/

echo   $_SERVER['QUERY_STRING'];
