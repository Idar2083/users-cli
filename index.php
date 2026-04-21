<?php

require 'vendor/autoload.php';

use Tsimib\UsersCli\JsonUserRepository;
use Tsimib\UsersCli\MysqlUserRepository;

// .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$source = $_ENV['DB_SOURCE'] ?? 'json';

if ($source === 'mysql') {

    $pdo = new PDO (
        "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );

    $repository = new MysqlUserRepository($pdo);

} else {
    $repository = new JsonUserRepository(__DIR__ . '/users.json');
}

// CLI
$command = $argv[1] ?? null;
$argument = $argv[2] ?? null;

if($command === 'users:list') {
    $users = ($repository->getAllUsers());
    print_r($users);

} elseif ($command === 'users:add') {

    if (empty($argument)) {
        echo "Missing user name\n";
        exit(1);
    }
    $repository->addUser($argument);
    echo "User added\n";

} elseif ($command === 'users:delete') {

    if (empty($argument)) {
        echo "Missing user ID\n";
        exit(1);
    }
    $repository->deleteUser((int)$argument);
    echo "User deleted\n";

} else {
    echo "Unknown command\n";
}