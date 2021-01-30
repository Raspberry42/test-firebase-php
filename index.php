<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('secret/test-cb42f-f9d8f278b806.json');

$firestore = $factory->createFirestore();
$database = $firestore->database();

$ref = $database->collection('messages');
$snapshot = $ref->documents();

// var_dump($snapshot);

/** @var iterable<\Google\Cloud\Firestore\DocumentSnapshot> $documents */
$documents = $ref->documents();

foreach ($documents as $document) {
    echo $document->path().PHP_EOL;

    echo PHP_EOL;

    print_r($document->data());

    echo PHP_EOL.'---'.PHP_EOL.PHP_EOL;
}
