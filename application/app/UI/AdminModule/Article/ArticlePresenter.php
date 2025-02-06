<?php

namespace App\UI\AdminModule\Article;

use App\Forms\Admin\Article\ArticleCreateForm;
use App\Forms\Admin\Article\ArticleEditForm;
use App\Services\ArticleService;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class ArticlePresenter extends Presenter
{
    public function __construct(
        private readonly ArticleService $articleService
    ){
        parent::__construct();
    }
    public function renderDefault(): void
    {
        $this->template->articles = $this->articleService->getAllArticles();
        $this->template->categories = $this->articleService->getAllCategories();
    }

    protected function createComponentArticleCreateForm(): Form
    {
        $categories = $this->articleService->getAllCategories();
        $form = (new ArticleCreateForm())->create($categories);
        $form->onSuccess[] = [$this, 'processArticleCreateForm'];

        return $form;
    }

    public function processArticleCreateForm(Form $form, $values): void
    {
        $result = $this->articleService->createArticle(
            title: $values->title,
            categoryId: $values->category,
            content: $values->content,
        );

        if ($result) {
            $this->flashMessage("Article '$values->title' was successful created!");
            $this->redirect('default');
        } else {
            $this->flashMessage('Article was not created!');
        }
    }

    public function renderCreate(): void
    {
    }

    protected function createComponentArticleEditForm(): Form
    {
        $categories = $this->articleService->getAllCategories();

        $form = (new ArticleEditForm())->create(
            $categories,
        );
        $form->onSuccess[] = [$this, 'processArticleEditForm'];

        return $form;
    }

    public function processArticleEditForm(Form $form, $values): void
    {
        $result = $this->articleService->editArticle(
            articleId: (int) $values->id,
            title: $values->title,
            categoryId: (int) $values->category,
            content: $values->content,
        );

        if ($result) {
            $this->flashMessage("Article '$values->title' was successful edited!");
            $this->redirect('default');
        } else {
            $this->flashMessage('Article wasn\'t edited!');
        }
    }


    public function renderEdit(int $id): void
    {
        $currentArticle = $this->articleService
            ->findArticleById($id);
        $this->getComponent('articleEditForm')
            ->setDefaults([
                'id' => $id,
                'title' => $currentArticle->title,
                'category' => $currentArticle->category_id,
                'content' => $currentArticle->content,
            ]);

        $this->template->article = $currentArticle;
    }

    public function renderCategory(int $id): void
    {
        $this->template->category = $this->articleService
            ->getAllCategories()->get($id)->category_name;

        $this->template->articles = $this->articleService
            ->getArticlesByCategoryId($id);
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