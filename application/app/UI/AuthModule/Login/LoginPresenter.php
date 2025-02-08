<?php

namespace App\UI\AuthModule\Login;

use App\Core\BasePresenter;
use App\Forms\Auth\LoginForm;
use App\Model\UserModel;
use App\Services\ActionLogService;
use Nette\Application\UI\Form;

class LoginPresenter extends BasePresenter
{
    public function __construct(
        private readonly LoginForm              $form,
        private readonly UserModel            $userModel,
        private readonly ActionLogService $actionLogService,
    ){
    }

    public function createComponentLoginForm(): Form
    {
        $form = $this->form->create();
        $form->onSuccess[] = [$this, 'processLoginForm'];

        return $form;
    }

    public function processLoginForm(Form $form, $values): void
    {
        $user = $this->userModel->findByUsername($values->username)->fetch();
        $sessionSection = $this->getSession('user');

        try {
            if (!$user || !password_verify($values->password, $user->password)) {
                throw new \Exception('Wrong username or password');
            }

            $sessionSection->userId = $user->id;
            $sessionSection->username = $user->username;
            $sessionSection->permissionLevel = $user->permissionLevel;

        } catch (\Exception $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        if ($sessionSection->permissionLevel == 2) {
            $this->actionLogService->createActionLog(
                executorId: $sessionSection->userId,
                action: "User $sessionSection->username have logged in administration module",
            );
            $this->redirect(':Admin:Dashboard:default');
        } else {
            $this->redirect(':Front:Home:default');
        }
    }

    public function renderDefault(): void
    {
        $this->template->loginForm = $this->form;
    }
}