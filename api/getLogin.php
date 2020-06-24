<?php 
    require '../autentication.php';
    require '../connection.php';
    //$body = json_decode(file_get_contents('php://input'),true);
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $collection = $conn->lab2dev->access;
    $query = array(
        'username' => $user,
        'password' => $pass
    );
    $result = $collection->find($query)->toArray();
    $myJSON = json_encode($result);
    
    echo $myJSON;
    header('Content-Type: application/json');
    header('HTTP/1.0 200');
?>