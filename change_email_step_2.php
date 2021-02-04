<?php

declare(strict_types=1);

use Kreait\Firebase\Factory;

require_once __DIR__.'/vendor/autoload.php';

$factory = (new Factory)->withServiceAccount(__DIR__.'/secret/test-cb42f-f9d8f278b806.json');

$auth = $factory->createAuth();
$firestore = $factory->createFirestore();

$changeRequests = $firestore->database()->collection('email_change_requests');

// You get the token from the request and make sure to validate it
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

$doc = $changeRequests->document($token)->snapshot();

if (!$doc->exists()) {
    echo "Error: The token was not found";
    exit;
}

try {
    $user = $auth->getUser($doc['uid']);
} catch (Throwable $e) {
    echo "Error: The user belonging to this token does not exist (any more?)";
    exit;
}

if ($user->email === $doc['new']) {
    echo "The email has already been changed";
    exit;
}

if ($user->email !== $doc['old']) {
    echo "Error: Mismatching data";
    exit;
}

try {
    $updatedUser = $auth->changeUserEmail($user->uid, $doc['new']);
} catch (Throwable $e) {
    // This can happen for example when the new email is already
    // assigned to another user.
    echo "Error while updating user email: {$e->getMessage()}";
}

echo "SUCCESS";