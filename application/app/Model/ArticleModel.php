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

    public function findAllByCategoryId(string $category_name): \Nette\Database\Table\Selection
    {
        $category = $this->database->table($this->category_table)->where('category_name', $category_name)->first();
        return $this->database->table($this->table)->where('category_id', $category->category_id)->fetchAll();
    }

    public function findById(int $id): \Nette\Database\Table\ActiveRow
    {
        return $this->database->table($this->table)->where('id', $id)->first();
    }

    public function insert(array $data): int
    {
        return $this->database->table($this->table)->insert($data);
    }

    public function update(int $id, array $data): int
    {
        return $this->database->table($this->table)->where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return $this->database->table($this->table)->where('id', $id)->delete();
    }
}