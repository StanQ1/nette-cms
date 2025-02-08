<?php

namespace App\Services;

use App\Core\BaseModel;
use App\Model\UserModel;
use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

class UserService extends BaseModel
{
    public function __construct(
        private readonly UserModel $userModel,
        private readonly Explorer $explorer
    ){
        parent::__construct($this->explorer);
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

    public function findUserByUsername(string $username): Selection
    {
        return $this->userModel->findByUsername($username);
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