<?php

namespace App\UI\AuthModule\Register;

use App\Core\BasePresenter;
use App\Forms\Auth\RegistrationForm;
use App\Model\UserModel;
use App\Services\ActionLogService;
use App\Services\ConfigurationService;
use App\Services\UserService;
use Nette\Application\UI\Form;

class RegisterPresenter extends BasePresenter
{
    public function __construct(
        private readonly RegistrationForm       $form,
        private readonly UserService            $userService,
        private readonly UserModel $userModel,
        private readonly  ActionLogService $actionLogService,
    ){
    }

    protected function createComponentRegisterForm(): Form
    {
        $form = $this->form->create();
        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form, $values): void
    {
        try {

            $this->userService->createUser(
                $values->username,
                $values->password,
            );

            $user = $this->userModel->findByUsername($values->username)->fetch();

            $sessionSection = $this->getSession('user');
            $sessionSection->userId = $user->id;
            $sessionSection->username = $user->username;
            $sessionSection->permissionLevel = $user->permissionLevel;

            $this->actionLogService->createActionLog(
                executorId: $sessionSection->userId,
                action: "User $sessionSection->username successfully registered",
            );
        } catch (\Exception $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }
        $this->redirect(':Front:Home:default');
    }
    public function renderDefault(): void
    {
        $this->template->registerForm = $this->form;
    }
}