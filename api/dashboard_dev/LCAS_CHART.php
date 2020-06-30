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
    ],
    [
        '$sort' => [
            'date_created' => -1
        ]
    ],
    [
        '$limit' => 10
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
        'HOUR' => $CAS['date_created']->toDateTime()->setTimezone($tz)->format('H:i'),
        'TEMP' => $CAS['temp']
    ];
    array_push($data, $dThis);
}

header('Content-type: application/json');
$return = [
    "data" => $data
];
echo json_encode($return);
