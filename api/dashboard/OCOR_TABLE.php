<?php

require '../../autentication.php';
require '../../connection.php';
$comp = $_POST['comp'];
$data = [];
$aggrCust = [
    [
        '$lookup' => [
            "from" => 'unity',
            "localField" => 'fk_uni',
            "foreignField" => 'id',
            "as" => 'unidade'
        ]
    ],
    [
        '$project' => [
            'id' => '$id',
            'name' => '$name',
            'rfid' => '$rfid',
            'comp' => '$unidade.fk_company'
        ]
    ],
    [
        '$match' => [
            "comp" => intval($comp),
        ]
    ],
    [
        '$sort' => [
            'name' => 1
        ]
    ],
    [
        '$limit' => 10
    ]
];
$CUSTS = $conn->lab2dev->customer->aggregate($aggrCust)->toArray();
//print_r(json_encode($CUSTS));
foreach ($CUSTS as $key => $CUST) {
    $temp_log = [];
    $aggTEMP = [

        [
            '$match' => [
                "fk_rfid" => $CUST['rfid'],
            ]
        ],
        [
            '$sort' => [
                'date_created' => -1
            ]
        ],
        [
            '$project' => [
                'temp' =>  '$temp',
                'date_created' => '$date_created'
            ]
        ],
        [
            '$limit' => 4
        ]
        
    ];
    $TEMP = $conn->lab2dev->totem_log->aggregate($aggTEMP)->toArray();
    //print_r(json_encode($TEMP));
    foreach($TEMP as $key => $t){
        $tThis = [
            'VALUE'=> $t['temp'],
            'DATE' => $t['date_created']->toDateTime()->setTimezone($tz)->format('d/m/yy H:i')
        ];
        array_push($temp_log,$tThis);
    }
    $dThis = [
        'NAME' => $CUST['name'],
        'HOUR' => $TEMP[0]['date_created']->toDateTime()->setTimezone($tz)->format('H:i'),
        'TEMP' => $temp_log,  
        'STATUS' => 0        
    ];
    array_push($data, $dThis);
}

header('Content-type: application/json');
$return = [
    "data" => $data
];
echo json_encode($return);
