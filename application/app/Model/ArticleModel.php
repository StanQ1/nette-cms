<?php

namespace App\Model;

use App\Core\BaseModel;

class ArticleModel extends BaseModel
{
    protected string $table = 'articles';
    protected string $category_table = 'article_categories';

    public function findAll(): \Nette\Database\Table\Selection
    {
        return $this->database->table($this->table);
    }

    public function getTableName(): string
    {
        return $this->table;
    }

    public function getCategoryTableName(): string
    {
        return $this->category_table;
    }

    public function findAllByCategoryId(int $category_id): \Nette\Database\Table\Selection
    {
        return $this->database->table($this->table)->where('category_id', $category_id)->fetchAll();
    }

    public function findById(int $id): \Nette\Database\Table\ActiveRow
    {
        return $this->database->table($this->table)->where('id', $id)->first();
    }

    public function insert(array $data): bool
    {
        return $this->database->table($this->table)->insert($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->database->table($this->table)->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->database->table($this->table)->where('id', $id)->delete();
    }
}