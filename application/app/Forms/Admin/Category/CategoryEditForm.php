<?php

namespace App\Forms\Admin\Category;

use Nette\Application\UI\Form;

class CategoryEditForm
{
    /**
     * @return Form
     */
    public function create(): Form
    {
        $form = new Form();

        $form
            ->addHidden('category_id');
        $form->addHidden('current_category_name');
        $form
            ->addText('category_name', 'Category name: ')
            ->setRequired('Category name is required.');
        $form
            ->addSubmit('send', 'Edit');

        return $form;
    }
}