<?php

namespace App\Model;

use App\Core\BaseModel;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class UserModel extends BaseModel
{
    private string $table = 'users';

    public function getTableName(): string
    {
        return $this->table;
    }

    public function findAll(): array
    {
        return $this->database->table($this->table)->fetchAll();
    }

    public function findByUsername(string $username): Selection
    {
        return $this->database->table($this->table)->where("username", $username);
    }
}