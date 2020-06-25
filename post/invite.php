<?php 
    require '../autentication.php';
    require '../connection.php';
    $collection = $conn->lab2dev->invite_access;
    $data = json_decode(json_encode($_POST,JSON_NUMERIC_CHECK ),JSON_NUMERIC_CHECK);
    $data['id'] = getLastId('inviteid',$conn);
    $result = $collection->insertOne($data);
    $myJSON = json_encode($result);
    header('Content-type: application/json');
    echo $myJSON;
?>