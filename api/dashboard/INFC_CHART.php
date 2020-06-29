<?php

require '../../autentication.php';
require '../../connection.php';
$comp = $_POST['comp'];
$type = $_POST['type'];
$label = [];
if ($type == 'm') {
    $label = [
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
    ];
    $data = [];
    for ($i=1; $i < 13; $i++) { 
        $aggJUN = [
            [
                '$lookup' => [
                    "from" => 'totem',
                    "localField" => 'fk_totem',
                    "foreignField" => 'id',
                    "as" => 'totem'
                ]
            ],
            [
                '$project' => [
                    'name' => 1,
                    'month' => [
                        '$month' => '$date_created'
                    ],
                    'comp' => '$totem.fk_company',
                    'temp' => '$temp'
                ]
            ],
            [
                '$match' => [
                    "comp" => intval($comp),
                    'month' => $i,
                    "temp" => [
                        '$gte' => 37
                    ]
                ]
            ],
            [
                '$count' => 'qtde'
            ],
        ];
        $rMounth = $conn->lab2dev->totem_log->aggregate($aggJUN)->toArray();
        if(!isset($rMounth[0]['qtde'])){
            $rMounth[0]['qtde'] = 0;
        }
        array_push($data,$rMounth[0]['qtde']);
    }
    
    
}
header('Content-type: application/json');

$return = [
    "label" => $label,
    "data" => $data
];
echo json_encode($return);
