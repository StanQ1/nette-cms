<?php

namespace App\UI\SetupModule\Setup;

use App\Core\BasePresenter;
use App\Services\ActionLogService;
use Nette\Application\UI\Form;
use App\Services\UserService;


final class SetupPresenter extends BasePresenter
{
    public function __construct(
        private readonly UserService $userService,
        private readonly ActionLogService $actionLogService,
    ){
    }
    protected function createComponentSettingsForm(): Form
    {
        // TODO: transit to Forms/Admin
        $defaultProjectName = $this->configurationService->getConfigurationValue('project_name');
        $defaultAdminUsername = $this->configurationService->getConfigurationValue('admin_username');

        $form = new Form();
        $form->addText('project_name', 'Project name: ')->setDefaultValue($defaultProjectName)
            ->setRequired('Project name is important!');
        $form->addHidden('current_project_name', $defaultProjectName);
        $form->addText('admin_username', 'Admin username: ')->setDefaultValue($defaultAdminUsername)
            ->setRequired('Your admin user should be exists!');
        $form->addHidden('current_admin_username')->setDefaultValue($defaultAdminUsername);
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

            $user = $this->userService->findUserByUsername($data->admin_username)->fetch();

            $this->actionLogService->createActionLog(
                executorId: $user->toArray()['id'],
                action: "Created administrator account $data->admin_username",
            );

            $this->actionLogService->createActionLog(
                executorId: $user->toArray()['id'],
                action: "Project \"$data->project_name\" was configured by $data->admin_username",
            );

            $this->configurationService->setConfigurationValue('admin_username', $data->admin_username);
            $this->configurationService->setConfigurationValue('is_ready_to_use', 1);
        } else if ($this->configurationService->getConfigurationValue('is_ready_to_use') == 1) {
            $this->configurationService->setConfigurationValue('admin_username', $data->admin_username);
            $this->configurationService->setConfigurationValue(
                'admin_password',
                    password_hash($data->admin_password, PASSWORD_BCRYPT
                ));

            $user = $this->userService->findUserByUsername($data->current_admin_username)->fetch();

            $this->userService->editUser(
                $user->toArray()['id'],
                $data->admin_username,
                $data->admin_password,
            );

            if ($data->admin_username != $data->current_admin_username) {
                $this->actionLogService->createActionLog(
                    executorId: $this->getSession()->getSection('user')->userId,
                    action: "Administrator $data->current_admin_username has changed username to \"$data->admin_username\"",
                );
            }

            if ($data->current_project_name != $data->project_name) {
                $this->actionLogService->createActionLog(
                    executorId: $this->getSession()->getSection('user')->userId,
                    action: "Administrator $data->admin_username has changed project name to \"$data->project_name\"",
                );
            }

            $this->actionLogService->createActionLog(
                executorId: $this->getSession()->getSection('user')->userId,
                action: "Administrator $data->admin_username has updated project configuration",
            );
        }

        $this->flashMessage('Data is successful updated!');
        $this->redirect(':Admin:Dashboard:default');
    }

    public function renderDefault(): void
    {
        
    }

    public function renderSetup(): void
    {
        
    }
}