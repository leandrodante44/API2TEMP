<?php
    require 'vendor/autoload.php';
    use MongoDB\Client as Mongo;
    $user = "flavio";
    $pwd = 'paciencia';
    $sev = 'barbudao.duckdns.org';

    $conn = new Mongo("mongodb://${user}:${pwd}@${sev}:27017");

?> 