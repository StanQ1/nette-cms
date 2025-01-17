<?php

namespace App\UI\AdminModule\Article;

use App\Model\ArticleModel;
use Nette\Application\UI\Presenter;

final class ArticlePresenter extends Presenter
{
    private ArticleModel $articleModel;
    public function __construct(ArticleModel $article)
    {
        parent::__construct();
        $this->articleModel = $article;
    }
    public function renderDefault(): void
    {
        $this->template->articles = $this->articleModel->findAll();
    }
}