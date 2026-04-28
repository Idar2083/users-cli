<?php
namespace Tsimib\UsersCli;

use PDO;
use Tsimib\UsersCli\JsonUserRepository;
use Tsimib\UsersCli\MysqlUserRepository;
use Tsimib\UsersCli\UserRepositoryInterface;
function createRepository(string $source = 'json'): UserRepositoryInterface
{
    $source = $_ENV['DB_SOURCE'] ?? $source;

    if ($source === 'mysql') {

        $pdo = new PDO (
            "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );
        return new MysqlUserRepository($pdo);
    }

    return new JsonUserRepository(__DIR__ . '/users.json');
}
