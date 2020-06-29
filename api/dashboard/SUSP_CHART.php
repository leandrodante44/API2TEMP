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
        15,
        12,
        20,
        25,
        19,
        30,
        26,
        32,
        40,
        36,
        50
    ]
];
echo json_encode($return);
