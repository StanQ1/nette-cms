<?php

namespace App\Forms\Admin\Category;

use Nette\Application\UI\Form;

class CategoryCreateForm
{
    /**
     * @return Form
     */
    public function create(): Form
    {
        $form = new Form();

        $form
            ->addText('category_name', 'Category name: ')
            ->setRequired('Category name is required.');
        $form
            ->addSubmit('send', 'Create');

        return $form;
    }
}