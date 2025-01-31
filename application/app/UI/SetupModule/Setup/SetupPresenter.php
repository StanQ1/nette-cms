<?php

namespace App\UI\SetupModule\Setup;

use App\Core\BasePresenter;
use Nette\Application\UI\Form;
use App\Services\UserService;
use Nette\DI\Attributes\Inject;


final class SetupPresenter extends BasePresenter
{
    #[Inject]
    public UserService $userService;
    protected function createComponentSettingsForm(): Form
    {
        // TODO: transit to Forms/Admin
        $defaultProjectName = $this->configurationService->getConfigurationValue('project_name');
        $defaultAdminUsername = $this->configurationService->getConfigurationValue('admin_username');

        $form = new Form();
        $form->addText('project_name', 'Project name: ')->setDefaultValue($defaultProjectName)
            ->setRequired('Project name is important!');
        $form->addText('admin_username', 'Admin username: ')->setDefaultValue($defaultAdminUsername)
            ->setRequired('Your admin user should be exists!');
        $form->addPassword('admin_password', 'Admin password: ')
            ->addRule($form::MinLength, 'Password must be at least %d characters', 8)
            ->setRequired('Password field not be empty!');
        $form->addPassword('repeat_password', 'Repeat password: ')
            ->addRule($form::Equal, 'The passwords do not match', $form['admin_password'])
            ->setRequired('Password repeat field not be empty!');
        $form->addSubmit('send', 'Save Configuration');
        $form->onSuccess[] = [$this, 'settingsFormSucceded'];
        return $form;
    }

    public function settingsFormSucceded(Form $form, $data): void
    {
        $this->configurationService->setConfigurationValue('project_name', $data->project_name);

        // Create admin in DB while first setup
        if ($this->configurationService->getConfigurationValue('is_ready_to_use') == 0) {
            $this->userService->createUser($data->admin_username, $data->admin_password, 2);
            $this->configurationService->setConfigurationValue('is_ready_to_use', 1);
        } else {
            $this->configurationService->setConfigurationValue('admin_username', $data->admin_username);
            $this->configurationService->setConfigurationValue('admin_password', password_hash($data->admin_password, PASSWORD_BCRYPT));
            $this->userService->editUser($this->getSession()->getSection('user')->get('id'), $data->admin_username,  $data->admin_password);
        }

        $this->flashMessage('Data is successful updated!');
        $this->redirect(':Front:Home:default');
    }

    public function renderDefault(): void
    {
        
    }

    public function renderSetup(): void
    {
        
    }
}