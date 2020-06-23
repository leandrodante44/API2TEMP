<?php
    require 'vendor/autoload.php';
    use MongoDB\Client as Mongo;
    $user = "flavio";
    $pwd = 'paciencia';

    $mongo = new Mongo("mongodb://${user}:${pwd}@187.75.75.49:27017");
    $collection = $mongo->lab2dev->access;
    $result = $collection->find()->toArray();

    print_r($result);
?> 