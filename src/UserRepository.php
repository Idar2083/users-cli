<?php
namespace Tsimib\UsersCli;
class UserRepository
{
    private string $filePath;
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getAllUsers(): array
    {
        $data = file_get_contents($this->filePath);
        $users = json_decode ($data,true);
        if ($users === null) {
            return [];
        }
        return $users;
    }

    public function addUser(string $name): array
    {
        $users = $this->getAllUsers();
        $maxId = 0;

        foreach ($users as $user) {
            if ($user['id'] >= $maxId) {
                $maxId = $user['id'];

            }
        }
        $newId = $maxId + 1;
        $user = [
            'id' => $newId,
            'name' => $name,
        ];
        $users[] = $user;
        $json = json_encode ($users);
        $data = file_put_contents($this->filePath, $json);
        return $users;
    }

    public function deleteUser(int $id): array
    {
        $newUsers = [];
        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if ($user['id'] != $id) {
                $newUsers [] = $user;
            }
        }
        $json = json_encode ($newUsers);
        $data = file_put_contents($this->filePath, $json);
        return $newUsers;
    }

}
