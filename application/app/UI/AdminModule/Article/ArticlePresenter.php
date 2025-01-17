<?php

namespace App\UI\AdminModule\Article;

use App\Model\ArticleModel;
use Nette\Application\UI\Presenter;

final class ArticlePresenter extends Presenter
{
    public function __construct(private readonly ArticleModel $articleModel)
    {
        parent::__construct();
    }
    public function renderDefault(): void
    {
        $this->template->articles = $this->articleModel->findAll();
    }
}