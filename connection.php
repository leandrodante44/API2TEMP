<?php
    require 'vendor/autoload.php';
    require 'utils.php';
    $user = "flavio";
    $pwd = 'paciencia';
    $sev = 'barbudao.duckdns.org';

    $conn = new MongoDB\Client("mongodb://${user}:${pwd}@${sev}:27017");

?> 