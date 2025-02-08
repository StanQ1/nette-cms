<?php

namespace App\Forms\Admin\Article;

use Nette\Application\UI\Form;
use Nette\Database\Table\Selection;

class ArticleCreateForm
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
            ->addText('title', 'Title: ')
            ->setRequired();
        $form
            ->addTextArea('content', 'Content: ')
            ->setRequired();
        $form
            ->addSelect('category', 'Category: ', $processedCategories)
            ->setPrompt('Pick a category')
            ->setRequired();
        $form
            ->addSubmit('send', 'Create');

        return $form;
    }
}