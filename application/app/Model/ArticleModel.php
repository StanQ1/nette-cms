<?php

namespace App\Model;

use App\Core\BaseModel;
use Nette\Database\Table\ActiveRow;

class ArticleModel extends BaseModel
{
    protected string $articleTableName = 'articles';
    protected string $categoryTableName = 'article_categories';

    public function getArticleTableNameName(): string
    {
        return $this->articleTableName;
    }

    public function getCategoryTableNameName(): string
    {
        return $this->categoryTableName;
    }

    public function findAll(): \Nette\Database\Table\Selection
    {
        return $this->database->table($this->articleTableName);
    }

    public function findAllCategories(): \Nette\Database\Table\Selection
    {
        return $this->database->table($this->categoryTableName);
    }

    public function findAllByCategoryId(int $categoryId): \Nette\Database\Table\Selection
    {
        return $this->database->table($this->articleTableName)->where('category_id', $categoryId);
    }

    public function findById(int $id): \Nette\Database\Table\ActiveRow|null
    {
        return $this->database->table($this->articleTableName)->get($id);
    }

    public function insert(array $data): ActiveRow
    {
        return $this->database->table($this->articleTableName)->insert($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->database->table($this->articleTableName)->where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return $this->database->table($this->articleTableName)->get($id)->delete();
    }
}