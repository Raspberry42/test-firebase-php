<?php

declare(strict_types=1);

use Kreait\Firebase\Factory;
use Kreait\Firebase\Util\JSON;

require_once __DIR__.'/vendor/autoload.php';

$factory = (new Factory)->withServiceAccount(__DIR__.'/secret/test-cb42f-f9d8f278b806.json');

$auth = $factory->createAuth();

/*
// Remove all users
foreach ($auth->listUsers() as $user) {
    $auth->deleteUser($user->uid);
}
*/

/*
// Insert user
$userProperties = [
    'email' => 'jon-snow69955@yahoo.fr',
    'displayName' => 'jon snow',
    'password' => 'azerty',
    'emailVerified' => true,
    'disabled' => false
];

$createdUser = $auth->createUser($userProperties);
*/

$actionCodeSettings = [
    'continueUrl' => 'http://localhost/zone42/testfirebase/page2.php'
];

$auth->sendSignInWithEmailLink('jon-snow69955@yahoo.fr', $actionCodeSettings);
