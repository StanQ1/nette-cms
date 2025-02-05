<?php

namespace App\Services;

use App\Core\BaseModel;
use App\Model\ArticleModel;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

// TODO: Make a tests about all functions
class ArticleService extends BaseModel
{
    public function __construct(
        private readonly ArticleModel $articleModel
    ){
    }

    public function createArticle(string $title, int $category_id, string $content): bool
    {
        return $this->articleModel->insert([
            'title' => $title,
            'category_id' => $category_id,
            'content' => $content,
        ]);
    }

    public function editArticle(int $id, string $title, int $category_id, string $content): bool
    {
        return $this->articleModel->findById($id)->update([
            'title' => $title,
            'category_id' => $category_id,
            'content' => $content,
        ]);
    }

    public function deleteArticle(int $id): bool
    {
        return $this->articleModel->findById($id)->delete();
    }

    public function getAllArticles(): Selection
    {
        return $this->articleModel->findAll();
    }

    public function getArticlesByCategoryId(int $categoryId): Selection
    {
        return $this->articleModel->findAllByCategoryId($categoryId);
    }

    public function getArticleById(int $articleId): ActiveRow
    {
        return $this->articleModel->findById($articleId);
    }
}