<?php

require '../../autentication.php';
header('Content-type: application/json');
$return = [
    "data" => [
        [
            "NAME" => 'Leandro Dante Oliveira',
            "HOUR" => '12:00',
            "TEMP" => 35
        ],
        [
            "NAME" => 'Lael Jader',
            "HOUR" => '11:58',
            "TEMP" => 38
        ],
        [
            "NAME" => 'Flavio Alves',
            "HOUR" => '11:57',
            "TEMP" => 37
        ]
    ]
];
echo json_encode($return);
