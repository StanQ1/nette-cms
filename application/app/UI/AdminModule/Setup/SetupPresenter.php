<?php

namespace App\UI\AdminModule\Setup;

use App\Core\BasePresenter;
use Nette\Application\UI\Form;


final class SetupPresenter extends BasePresenter
{
    // public function __construct(
    //     private ConfigurationService $configurationService
    // ){
    // }

    protected function createComponentSettingsForm(): Form
    {
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
        $this->configurationService->setConfigurationValue('admin_username', $data->admin_username);
        $this->configurationService->setConfigurationValue('admin_password', password_hash($data->admin_password, PASSWORD_BCRYPT));
        $this->configurationService->setConfigurationValue('is_ready_to_use', 1);

        $this->flashMessage('Data is successful updated!');
        $this->redirect('Dashboard:default');
    }

    public function renderDefault(): void
    {
        
    }

    public function renderSetup(): void
    {
        
    }
}