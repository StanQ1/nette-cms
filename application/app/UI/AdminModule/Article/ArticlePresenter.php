<?php

namespace App\UI\AdminModule\Article;

use App\Services\ArticleService;
use Nette\Application\UI\Presenter;

final class ArticlePresenter extends Presenter
{
    public function __construct(private readonly ArticleService $articleService)
    {
        parent::__construct();
    }
    public function renderDefault(): void
    {
        $this->template->articles = $this->articleService->getAllArticles();
    }

    public function renderCreate(): void
    {
        // TODO: Write form processing logic
    }


    public function renderEdit(int $id): void
    {
        // TODO: Write form processing logic
        $this->template->article = $this->articleService->findArticleById($id);
    }

    public function actionDelete(int $id): void
    {
        $result = $this->articleService->deleteArticle($id);
        $response = $result ? 'You have successfully deleted article!'
            : 'Article not found!';
        $this->flashMessage($response);
        $this->redirectPermanent(':Admin:Article:default');
    }
}