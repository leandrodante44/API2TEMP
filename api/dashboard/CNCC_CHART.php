<?php

require '../../autentication.php';
header('Content-type: application/json');
$return = [
    "data" => [
        50,
        50
    ]
];
echo json_encode($return);
