<?php

require '../../autentication.php';
header('Content-type: application/json');
$return = [
    "label" => [
        "Janeiro",
        "Fevereiro",
        "Março",
        "Abril",
        "Maio",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Dezembro"
    ],
    "data" => [
        10,
        12,
        15,
        13,
        15,
        14,
        12,
        11,
        10,
        17,
        16,
        18
    ]
];
echo json_encode($return);