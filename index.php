<?php

require 'vendor/autoload.php';
use Tsimib\UsersCli\UserRepository;

$repository = new UserRepository("users.json");
$command = $argv[1] ?? null;
$argument = $argv[2] ?? null;

if($command === 'users:list') {
    $users = ($repository->getAllUsers());
    print_r($users);

} elseif ($command === 'users:add') {

    if (!$argument) {
        echo "Missing user name\n";
        exit(1);
    }
    $repository->addUser($argument);
    echo "User added\n";

} elseif ($command === 'users:delete') {

    if (!$argument) {
        echo "Missing user ID\n";
        exit(1);
    }
    $repository->deleteUser((int)$argument);
    echo "User deleted\n";

} else {
    echo "Unknown command\n";
}