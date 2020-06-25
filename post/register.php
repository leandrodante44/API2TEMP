<?php 
    require '../autentication.php';
    require '../connection.php';
    $collection = $conn->lab2dev->invite_access;
    $data = json_decode(json_encode($_POST,JSON_NUMERIC_CHECK),JSON_NUMERIC_CHECK);
    $options = [
        'sort' => [
            'date_created' => 1
        ], 
        'limit' => 1
    ];
    $query = [
        'email' => $data['email'],
        'status' => 1
    ];
    $validmail = $collection->find($query,$options)->toArray();
    if(isset($validmail[0]->email)){
        //email válido e com convite
        $data['id'] = getLastId('accessid',$conn);
    }else{
        header('Content-type: application/json');
        $jReturn = ["STATUS"=>"INVALID_INVITE"];
        echo $jReturn;
    }
    
    //$collection = $conn->lab2dev->invite_access;
    //$result = $collection->insertOne($data);
    //$myJSON = json_encode($result);
    //header('Content-type: application/json');
    //echo $myJSON;
?>
