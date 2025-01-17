<?php

namespace App\UI\FrontModule\Article;

use Nette\Application\UI\Presenter;

final class ArticlePresenter extends Presenter
{
    public function renderDefault(int $id): void
    {
        $this->template->id = $id;
    }
}