<?php 
    require '../autentication.php';
    require '../connection.php';
    //$body = json_decode(file_get_contents('php://input'),true);
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $comp = $_POST['comp'];
    $collection = $conn->lab2dev->access;
    $query = array(
        'email' => $user,
        'password' => $pass
    );
    $result = $collection->find($query)->toArray();
    $aggUni = array(
        array(
            '$lookup' => array(
                "from" => 'company',
                "localField" => 'fk_company',
                "foreignField" => 'id',
                "as" => 'comp_uni'
            )
        ),
        array(
            '$match' => array(
                "comp_uni.code" => $comp
            )
        ),
        array(
            '$group' => array(
                "_id" => '$_id',
                "id_unidade" =>array('$first' => '$id'),
            )
        ),
    );
    $unidade = $conn->lab2dev->unity->aggregate($aggUni)->toArray();
    if(( isset($unidade[0]) && $unidade[0]->id_unidade) == $result[0]->fk_uni ){
        $jReturn = json_encode($result);
        echo $jReturn;
    }else{
        echo '{"STATUS":"INVALID COMPANY"}';
    }
    header('Content-Type: application/json');
    header('HTTP/1.0 200');
    
?>