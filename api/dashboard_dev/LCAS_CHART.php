<?php

require '../../autentication.php';
require '../../connection.php';
$comp = $_POST['comp'];
$data = [];
$aggLCAS = [
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
            'rfid' => '$fk_rfid',
            'temp' => '$temp',
            'date_created' => '$date_created',
            'comp' => '$totem.fk_company'
        ]
    ],
    [
        '$match' => [
            "comp" => intval($comp),
        ]
    ]
];
$LCAS = $conn->lab2dev->totem_log->aggregate($aggLCAS)->toArray();
foreach ($LCAS as $key => $CAS) {
    $aggCUST = [

        [
            '$match' => [
                "rfid" => $CAS['rfid'],
            ]
        ],
        [
            '$project' => [
                'name' =>  '$name'
            ]
        ],
    ];
    $CUST = $conn->lab2dev->customer->aggregate($aggCUST)->toArray();
    $dThis = [
        'NAME' => $CUST[0]['name'],
        'HOUR' => date('Y-m-d H:i:s',$CAS['date_created']->date),
        'TEMP' => $CAS['temp']
    ];
    array_push($data,$dThis);
}

header('Content-type: application/json');
$return = [
    "data" => $data
];
echo json_encode($return);
