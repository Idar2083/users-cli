<?php
namespace Tsimib\UsersCli;
class JsonUserRepository implements UserRepositoryInterface
{
    public function __construct(private string $filePath) {}
    public function getAllUsers(): array
    {
        $data = file_get_contents($this->filePath);

        if ($data === false || $data === '') {
            return [];
        }

        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }

    public function addUser(string $name): array
    {
        $users = $this->getAllUsers();

        $ids = array_column($users, 'id');
        $maxId = empty($ids) ? 0 : max($ids);

        $newUser = [
            'id' => $maxId + 1,
            'name' => $name,
        ];

        $users[] = $newUser;

        $json = json_encode($users, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        if (file_put_contents($this->filePath, $json) === false) {
            throw new \RuntimeException('Unable to write to file');
        }

        return $newUser;
    }

    public function deleteUser(int $id): array
    {
        $users = $this->getAllUsers();

        $newUsers = array_filter($users, fn ($user) => $user['id'] !== $id);

        $newUsers = array_values($newUsers);

        $json = json_encode($newUsers, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        if (file_put_contents($this->filePath, $json) === false) {
            throw new \RuntimeException('Unable to write to file');
        }

        return $newUsers;
    }

}
