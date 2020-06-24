<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header ("Access-Control-Allow-Headers: *");
//if (!isset($_SERVER['PHP_AUTH_USER'])) {
//    header('WWW-Authenticate: Basic realm="LAB2TEMP"');
//    header('HTTP/1.0 401 Unauthorized');
//    exit;
//} else {
//    if(!($_SERVER['PHP_AUTH_USER'] == 'dev' && $_SERVER['PHP_AUTH_PW'] == 'lab2dev'))
//    {
//        header('WWW-Authenticate: Basic realm="LAB2TEMP"');
//        header('HTTP/1.0 401 Unauthorized');
//        exit;
//    }
//}
?>
