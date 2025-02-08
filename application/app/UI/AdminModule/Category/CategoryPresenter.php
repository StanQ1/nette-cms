<?php

namespace App\UI\AdminModule\Category;

use App\Core\BasePresenter;
use App\Forms\Admin\Category\CategoryCreateForm;
use App\Forms\Admin\Category\CategoryEditForm;
use App\Services\ActionLogService;
use App\Services\CategoryService;
use Nette\Application\UI\Form;

final class CategoryPresenter extends BasePresenter
{
    public function __construct(
        private readonly ActionLogService $actionLogService,
        private readonly CategoryService $categoryService,
    ){
    }
    public function renderDefault(): void
    {
        $this->template->categories = $this->categoryService->getAllCategories();
    }

    protected function createComponentCategoryCreateForm(): Form
    {
        $form = (new CategoryCreateForm())->create();
        $form->onSuccess[] = [$this, 'processCategoryCreateForm'];

        return $form;
    }

    public function processCategoryCreateForm(Form $form, $values): void
    {
        $result = $this->categoryService->createCategory(
            categoryName: $values->category_name,
        );

        if ($result) {
            $user = $this->getSession()->getSection('user');
            $this->actionLogService->createActionLog(
                executorId: $user->get('userId'),
                action: "User {$user->get('username')} has created a new category: \"{$values->category_name}\"",
            );

            $this->flashMessage("Category '$values->category_name' was successful created!");
            $this->redirect('default');
        } else {
            $this->flashMessage('Category was not created!');
        }
    }

    public function renderCreate(): void
    {

    }

    protected function createComponentCategoryEditForm(): Form
    {
        $form = (new CategoryEditForm())->create();
        $form->onSuccess[] = [$this, 'processCategoryEditForm'];

        return $form;
    }

    public function processCategoryEditForm(Form $form, $values): void
    {
        $result = $this->categoryService->editCategory(
            id: $values->category_id,
            categoryName: $values->category_name,
        );

        if ($result) {
            $user = $this->getSession()->getSection('user');
            $this->actionLogService->createActionLog(
                executorId: $user->get('userId'),
                action: "User {$user->get('username')} 
                    has successfully renamed \"{$values->current_category_name}\" 
                    category to \"{$values->category_name}\"",
            );

            $this->flashMessage("Category '$values->category_name' was successful edited!");
            $this->redirect('default');
        } else {
            $this->flashMessage('Category wasn\'t edited!');
        }
    }

    public function renderEdit(int $id): void
    {
        $category = $this->categoryService->getCategoryById($id);
        $this->getComponent('categoryEditForm')
            ->setDefaults([
                'current_category_name' => $category->category_name,
                'category_id' => $category->id,
                'category_name' => $category->category_name,
            ]);
        $this->template->category = $category;
    }

    public function actionDelete(int $id): void
    {
        $categoryName = $this->categoryService->getCategoryById($id)->category_name;
        $user = $this->getSession()->getSection('user');

        if ($this->categoryService->deleteCategory($id)) {
            $this->actionLogService->createActionLog(
                executorId: $user->userId,
                action: "User $user->username has deleted a \"$categoryName\" category",
            );
            $this->flashMessage("Category \"$categoryName\" has been deleted.");
        } else {
            $this->flashMessage("Category \"$categoryName\" was not deleted.");
        }

        $this->redirect('default');
    }
}