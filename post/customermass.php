<?php 
    require '../autentication.php';
    require '../connection.php';
    $collection = $conn->lab2dev->customer;
    $data = json_decode(json_encode($_POST['data'],JSON_NUMERIC_CHECK),JSON_NUMERIC_CHECK);
    foreach($data as $cust){
        $cust['id'] = getLastId('customerid',$conn);
        $collection->insertOne($cust);
    }    
    header('Content-type: application/json');
    echo json_encode(["STATUS"=>'OK'])
?> 