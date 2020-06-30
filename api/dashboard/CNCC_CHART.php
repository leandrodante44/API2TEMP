<?php
/* CASOS NORMAIS 

MONGO SCRIPT
db.getCollection("totem_log").aggregate([
  {
    $lookup: {
      from: "totem",
      localField: "fk_totem",
      foreignField: "id",
      as: "totem",
    },
  },
  {
    $match: {
      "totem.fk_company": 1,
      temp: {
        $lt: 37,
      },
    },
  },
  {
    $count: "count_normal",
  },
]);

/* CASOS CRITICOS 

MONGO SCRIPT
db.getCollection("totem_log").aggregate([
  {
    $lookup: {
      from: "totem",
      localField: "fk_totem",
      foreignField: "id",
      as: "totem",
    },
  },
  {
    $match: {
      "totem.fk_company": 1,
      temp: {
        $gte: 37,
      },
    },
  },
  {
    $count: "count_crit",
  },
]);


*/
require '../../autentication.php';
require '../../connection.php';
$comp = $_POST['comp'];
$aggCN = [
    [
        '$lookup' => [
            "from" => 'totem',
            "localField" => 'fk_totem',
            "foreignField" => 'id',
            "as" => 'totem'
        ]
    ],
    [
        '$match' => [
            "totem.fk_company" => intval($comp),
            "temp" => [
                '$lt' => 37.5
            ]
        ]
    ],
    [
        '$count' => 'count_normal'
    ],
];
$cn = $conn->lab2dev->totem_log->aggregate($aggCN)->toArray();

$aggCC = [
    [
        '$lookup' => [
            "from" => 'totem',
            "localField" => 'fk_totem',
            "foreignField" => 'id',
            "as" => 'totemobj'
        ]
    ],
    [
        '$match' => [
            "totemobj.fk_company" => intval($comp),
            "temp" => [
                '$gte' => 37.5
            ]
        ]
    ],
    [
        '$count' => 'count_crit'
    ],
];
$cc = $conn->lab2dev->totem_log->aggregate($aggCC)->toArray();

if (!isset($cc[0])) {
    $cc[0]['count_crit'] = 0;
}
if (!isset($cn[0])) {
    $cn[0]['count_normal'] = 0;
}

header('Content-type: application/json');
$return = [
    "data" => [
        $cn[0]['count_normal'],
        $cc[0]['count_crit']
    ]
];
echo json_encode($return);
