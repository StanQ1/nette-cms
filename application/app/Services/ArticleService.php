<?php

namespace App\Services;

use App\Core\BaseModel;
use App\Model\ArticleModel;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class ArticleService extends BaseModel
{
    public function __construct(
        private readonly ArticleModel $articleModel
    ){
    }

    public function createArticle(string $title, int $categoryId, string $content): bool
    {
        return $this->articleModel->insert([
            'title' => $title,
            'category_id' => $categoryId,
            'content' => $content,
        ]);
    }

    public function findArticleById(int $id): ActiveRow|null
    {
        return $this->articleModel->findById($id);
    }

    public function editArticle(int $articleId, string $title, int $categoryId, string $content): bool
    {
        if (!is_null($this->articleModel->findById($articleId))) {
            return $this->articleModel->update(
                id: $articleId,
                data: [
                    'title' => $title,
                    'category_id' => $categoryId,
                    'content' => $content,
                ],
            );
        } else {
            return false;
        }
    }

    public function deleteArticle(int $id): bool
    {
        if (!is_null($this->findArticleById($id))) {
            $this->articleModel->delete($id);
            return true;
        } else {
            return false;
        }
    }

    public function getAllArticles(): Selection
    {
        return $this->articleModel->findAll();
    }

    public function getArticlesByCategoryId(int $categoryId): Selection
    {
        return $this->articleModel->findAllByCategoryId($categoryId);
    }
}