<?php
namespace Tsimib\UsersCli;

interface UserRepositoryInterface
{
    public function getAllUsers(): array;
    public function AddUser(string $name): array;
    public function deleteUser(int $id): array;
}