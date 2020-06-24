<?php 
    require '../autentication.php';
    require '../connection.php';
    $body = json_decode(file_get_contents('php://input'),true);
    $collection = $conn->lab2dev->access;
    $query = $_POST;
    $result = $collection->find($query)->toArray();
    $myJSON = json_encode($result);
    header('Content-type: application/json');
    echo $myJSON
?>