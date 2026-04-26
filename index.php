<?php

require 'vendor/autoload.php';

use Tsimib\UsersCli\JsonUserRepository;
use Tsimib\UsersCli\MysqlUserRepository;
use function Tsimib\UsersCli\createRepository;

// .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$source = $_ENV['DB_SOURCE'] ?? 'json';

$repository = createRepository($source);
// CLI
$command = $argv[1] ?? null;
$argument = $argv[2] ?? null;

if($command === 'users:list') {
    $users = ($repository->getAllUsers());
    print_r($users);

} elseif ($command === 'users:add') {

    if (empty($argument)) {
        echo "Missing user name" . PHP_EOL;
        exit(1);
    }
    $repository->addUser($argument);
    echo "User added" . PHP_EOL;

} elseif ($command === 'users:delete') {

    if (empty($argument)) {
        echo "Missing user ID" . PHP_EOL;
        exit(1);
    }
    $repository->deleteUser((int)$argument);
    echo "User deleted" . PHP_EOL;

} else {
    echo "Unknown command" . PHP_EOL;
}