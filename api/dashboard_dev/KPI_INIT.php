<?php

require '../../autentication.php';
header('Content-type: application/json');
$return = [
    "TTEN"    => 1000,
    "TTEN_R"  => 3,
    "ENNM"    => 980,
    "ENNM_R"  => 3,
    "ENCR"    => 20,
    "ENCR_R"  => 3,
    "IDSP"    => 2,
    "IDSP_R"  => 1
];
echo json_encode($return);