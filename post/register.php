<?php
require '../autentication.php';
require '../connection.php';
$collection = $conn->lab2dev->invite_access;
$data = json_decode(json_encode($_POST, JSON_NUMERIC_CHECK), JSON_NUMERIC_CHECK);
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
$validmail = $collection->find($query, $options)->toArray();
if (isset($validmail[0]->email)) {
    //email válido e com convite
    $data['id'] = getLastId('accessid', $conn);
    $data['email'] = $validmail[0]->email;
    $data['fk_uni'] = $validmail[0]->fk_uni;
    $data['fk_company'] = $validmail[0]->fk_company;
    $data['level_access'] = $validmail[0]->level_access;
    $data['status'] = 1;
    $data['password'] = strval($data['password']);
    $where = ['email' => $data['email']];
    $set = ['$set' => ['status' => 0]];
    $collection->updateOne($where, $set);
    $collection = $conn->lab2dev->access;
    $query = array(
        'email' => $data['email']
    );

    $result = $collection->find($query)->toArray();
    if (isset($result[0])) {
        header('Content-type: application/json');
        $jReturn = ["STATUS" => "EMAIL_INVALID"];
        echo json_encode($jReturn);
    } else {
        $collection->insertOne($data);

        header('Content-type: application/json');
        $jReturn = ["STATUS" => "OK"];
        echo json_encode($jReturn);
    }
} else {
    header('Content-type: application/json');
    $jReturn = ["STATUS" => "INVALID_INVITE"];
    echo json_encode($jReturn);
}
