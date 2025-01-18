<?php

namespace App\UI\AuthModule\Register;

use App\Core\BasePresenter;
use App\Forms\Auth\RegistrationForm;
use App\Services\ConfigurationService;
use App\Services\UserService;
use Nette\Application\UI\Form;

class RegisterPresenter extends BasePresenter
{
    public function __construct(
        private readonly RegistrationForm       $form,
        private readonly UserService            $userService,
        protected ConfigurationService $configurationService,
    ){
        parent::__construct($this->configurationService);
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
        } catch (\Exception $e) {
            $form->addError($e->getMessage());
        }
    }
    public function renderDefault(): void
    {
        $this->template->registerForm = $this->form;
    }
}