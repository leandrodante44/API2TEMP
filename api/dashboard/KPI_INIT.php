<?php

require '../../autentication.php';
require '../../connection.php';
$comp = $_POST['comp'];
$aggTTEN = [
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
            'comp' => '$totem.fk_company'
        ]
    ],
    [
        '$match' => [
            "comp" => intval($comp),
            'month' => intval(date('m'))
        ]
    ],
    [
        '$count' => 'qtde'
    ],
];
$TTEN = $conn->lab2dev->totem_log->aggregate($aggTTEN)->toArray();
if (!isset($TTEN[0]['qtde'])) {
    $TTEN[0]['qtde'] = 0;
}
$aggTTEN_L = [
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
            'comp' => '$totem.fk_company'
        ]
    ],
    [
        '$match' => [
            "comp" => intval($comp),
            'month' => intval(date('m')) - 1
        ]
    ],
    [
        '$count' => 'qtde'
    ],
];
$TTEN_L = $conn->lab2dev->totem_log->aggregate($aggTTEN_L)->toArray();
if (!isset($TTEN_L[0]['qtde']) || $TTEN_L[0]['qtde'] == 0) {
    $TTEN_L[0]['qtde'] = 0;
    $TTEN_R = 0;
} else {
    $TTEN_R = (($TTEN[0]['qtde'] / $TTEN_L[0]['qtde']) - 1) * 100;
}


$aggENCR = [
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
            'month' => intval(date('m')),
            'temp' => [
                '$gte' => 37.5
            ]
        ]
    ],
    [
        '$count' => 'qtde'
    ],
];
$ENCR = $conn->lab2dev->totem_log->aggregate($aggENCR)->toArray();
if (!isset($ENCR[0]['qtde'])) {
    $ENCR[0]['qtde'] = 0;
}
$aggENCR_L = [
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
            'month' => intval(date('m')) - 1,
            'temp' => [
                '$gte' => 37.5
            ]
        ]
    ],
    [
        '$count' => 'qtde'
    ],
];
$ENCR_L = $conn->lab2dev->totem_log->aggregate($aggENCR_L)->toArray();
if (!isset($ENCR_L[0]['qtde']) || $ENCR_L[0]['qtde'] == 0) {
    $ENCR_L[0]['qtde'] = 0;
    $ENCR_R = 0;
} else {
    $ENCR_R = (($ENCR[0]['qtde'] / $ENCR_L[0]['qtde']) - 1) * 100;
}

$ENNM = $TTEN[0]['qtde'] - $ENCR[0]['qtde'];
$ENNM_L = $TTEN_L[0]['qtde'] - $ENCR_L[0]['qtde'];
if ($ENNM_L == 0) {
    $ENNM_R = 0;
} else {
    $ENNM_R = (($ENNM / $ENNM_L) - 1) * 100;
}

if ($TTEN[0]['qtde'] == 0) {
    $IDSP = 0;
} else {
    $IDSP =   $ENCR[0]['qtde'] /$TTEN[0]['qtde'] * 100;
}
if ($TTEN_L[0]['qtde'] == 0) {
    $IDSP_L = 0;
} else {
    $IDSP_L =  $ENCR_L[0]['qtde']/$TTEN_L[0]['qtde'] * 100;
}
$IDSP_R = $IDSP - $IDSP_L;

header('Content-type: application/json');
$return = [
    "TTEN"    => $TTEN[0]['qtde'],
    "TTEN_R"  => round($TTEN_R,2),
    "ENNM"    => $ENNM,
    "ENNM_R"  => round($ENNM_R,2),
    "ENCR"    => $ENCR[0]['qtde'],
    "ENCR_R"  => round($ENCR_R,2),
    "IDSP"    => round($IDSP,2),
    "IDSP_R"  => round($IDSP_R,2)
];
echo json_encode($return);
