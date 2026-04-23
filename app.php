<?php

require 'vendor/autoload.php';
use Tsimib\UsersCli\UserRepository;

$repository = new UserRepository("users.json");
$command = $argv[1] ?? null;
$argument = $argv[2] ?? null;

if($command === 'users:list') {
    print_r($repository->getAllUsers());

} elseif ($command === 'users:add') {

    print_r($repository->addUser($argument));
    if (!$argument) {
        echo "Missing user name";
    }

} elseif ($command === 'users:delete') {

    print_r($repository->deleteUser($argument));
    if (!$argument) {
        echo "Missing user ID";
    }

} else {
    echo "Unknown command";
}