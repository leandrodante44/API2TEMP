<?php 
    require 'connection.php';
    $user = $_GET['usu'];
    $pass = $_GET['pas'];
    $collection = $conn->lab2dev->access;
    $result = $collection->find({})->toArray();

    print_r($result);
?>