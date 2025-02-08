<?php

namespace App\Forms\Admin\Article;

use Nette\Application\UI\Form;
use Nette\Database\Table\Selection;

class ArticleEditForm
{
    /**
     * @param Selection $categories
     * @return Form
     */
    public function create(Selection $categories): Form
    {
        $form = new Form();

        $processedCategories = [];

        foreach ($categories as $category) {
            $processedCategories[] = [
                $category->id => $category->category_name,
            ];
        }

        $form
            ->addHidden('id');
        $form
            ->addText('title', 'Title: ');
        $form
            ->addTextArea('content', 'Content: ');
        $form
            ->addSelect('category', 'Category: ', $processedCategories)
            ->setPrompt('Pick a category');
        $form
            ->addSubmit('send', 'Edit');

        return $form;
    }
}