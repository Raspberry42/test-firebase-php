<?php

declare(strict_types=1);

use Kreait\Firebase\Factory;

require_once __DIR__.'/vendor/autoload.php';

$factory = (new Factory)->withServiceAccount(__DIR__.'/secret/test-cb42f-f9d8f278b806.json');

$auth = $factory->createAuth();
$firestore = $factory->createFirestore();

$changeRequests = $firestore->database()->collection('email_change_requests');

$email = '...';
$password = 'password123';

$testUser = $auth->createUserWithEmailAndPassword($email, $password);

$uid = $testUser->uid;
$oldEmail = $testUser->email;
$newEmail = 'new...';

$user = $auth->getUser($uid);

$newRequest = $changeRequests->add([
    'old' => $oldEmail,
    'new' => $newEmail,
    'uid' => $uid,
]);

$token = $newRequest->id();

$actionCodeSettings = [
    'continueUrl' => 'http://localhost/zone42/testfirebase/change_email_step_2.php?token='.$token
];

$auth->sendSignInWithEmailLink($user->email, $actionCodeSettings);