<?php 
    require '../autentication.php';
    require '../connection.php';
    $collection = $conn->lab2dev->critical_log;
    $result = $collection->find(json_decode(json_encode($_POST,JSON_NUMERIC_CHECK ),JSON_NUMERIC_CHECK))->toArray();
    $myJSON = json_encode($result);
    header('Content-type: application/json');
    echo $myJSON
?>