<?php

namespace App\Services;

use App\Core\BaseModel;
use App\Model\UserModel;

class UserService extends BaseModel
{
    public function __construct(\Nette\Database\Explorer $database, private readonly UserModel $userModel)
    {
        parent::__construct($database);
    }

    /**
     * @throws \Exception
     */
    public function createUser(string $username, string $password, int $permissionLevel = 1): void
    {
        if (!is_null($this->userModel->findByUsername($username)->fetch())) {
            throw new \Exception("Username already exists");
        }

        $result = $this->database->table($this->userModel->getTableName())->insert([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'permissionLevel' => $permissionLevel,
        ]);

        if (!$result) {
            throw new \Exception('Failed to create user');
        }
    }

    public function editUser(int $id, string $username, $password): void
    {
        $user = $this->userModel->findById($id);
        $user->update([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }
}