<?php
namespace Tsimib\UsersCli;

use PDO;

class MysqlUserRepository implements UserRepositoryInterface
{
    public function __construct(private PDO $pdo) {}

    public function getAllUsers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $name): array
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);

        return [
            'id' => (int)$this->pdo->lastInsertId(),
            'name' => $name,
        ];
    }

    public function deleteUser(int $id): array
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return [];
    }

}