<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('secret/test-cb42f-f9d8f278b806.json');

$firestore = $factory->createFirestore();
$database = $firestore->database();

use Kreait\Firebase\Auth;

//$auth = (new Auth)-> ??????????

$userProperties = [
    'email' => 'user@example.com',
    'emailVerified' => false,
    'phoneNumber' => '+15555550100',
    'password' => 'secretPassword',
    'displayName' => 'John Doe',
    'photoUrl' => 'http://www.example.com/12345678/photo.png',
    'disabled' => false,
];

$createdUser = $auth->createUser($userProperties);

// This is equivalent to:

$request = \Kreait\Auth\Request\CreateUser::new()
    ->withUnverifiedEmail('user@example.com')
    ->withPhoneNumber('+15555550100')
    ->withClearTextPassword('secretPassword')
    ->withDisplayName('John Doe')
    ->withPhotoUrl('http://www.example.com/12345678/photo.png');

$createdUser = $auth->createUser($request);
