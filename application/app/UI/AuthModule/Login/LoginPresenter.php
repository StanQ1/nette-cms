<?php

namespace App\UI\AuthModule\Login;

use App\Core\BasePresenter;
use App\Forms\Auth\LoginForm;
use App\Model\UserModel;
use App\Services\ConfigurationService;
use App\Services\UserService;
use Nette\Application\UI\Form;

class LoginPresenter extends BasePresenter
{
    public function __construct(
        private readonly LoginForm              $form,
        private readonly UserModel            $userModel,
        protected ConfigurationService $configurationService,
    ){
        parent::__construct($this->configurationService);
    }

    public function createComponentLoginForm(): Form
    {
        $form = $this->form->create();
        $form->onSuccess[] = [$this, 'processLoginForm'];

        return $form;
    }

    public function processLoginForm(Form $form, $values): void
    {
        try {
            $user = $this->userModel->findByUsername($values->username)->fetch();

            if (!$user || !password_verify($values->password, $user->password)) {
                throw new \Exception('Wrong username or password');
            }

            $sessionSection = $this->getSession('user');
            $sessionSection->userId = $user->id;
            $sessionSection->username = $user->username;
            $sessionSection->permissionLevel = $user->permissionLevel;

            $this->flashMessage('Successful!', 'success');
            $this->redirect('Homepage:default');
        } catch (\Exception $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }
    }

    public function renderDefault(): void
    {
        $this->template->loginForm = $this->form;
    }
}