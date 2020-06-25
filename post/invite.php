<?php 
    require '../autentication.php';
    require '../connection.php';
    //$collection = $conn->lab2dev->invite_access;
    ////$result = $collection->insert(json_decode(json_encode($_POST,JSON_NUMERIC_CHECK ),JSON_NUMERIC_CHECK))->toArray();
    //$result = $collection->insertOne(json_decode(json_encode($_POST,JSON_NUMERIC_CHECK ),JSON_NUMERIC_CHECK));
    //$myJSON = json_encode($result);
    //header('Content-type: application/json');
    //echo $myJSON
    $data = $cursor->toArray();
    print_r($data);



?>