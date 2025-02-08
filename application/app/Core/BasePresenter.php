<?php

namespace App\Core;

use App\Services\ConfigurationService;
use Nette\Application\UI\Presenter;
use Nette\DI\Attributes\Inject;

class BasePresenter extends Presenter
{
    #[Inject]
    public ConfigurationService $configurationService;

    protected function startup(): void
    {
        parent::startup();

        $appIsReady = $this->configurationService->getConfigurationValue('is_ready_to_use');

        if ($appIsReady
            && $this->isModuleCurrent('Admin')
            && $this->getSession()->getSection('user')->get('permissionLevel') < 2
        ) {
            $this->error('Forbidden', \Nette\Http\IResponse::S403_FORBIDDEN);
        }

        if (
            $appIsReady
            && $this->isModuleCurrent('Setup')
            && $this->getSession()->getSection('user')->get('permissionLevel') < 2
        ) {
            $this->error('Forbidden', \Nette\Http\IResponse::S403_FORBIDDEN);
        }

        if (
            !$appIsReady && !$this->isModuleCurrent('Setup')
        ) {

            $this->redirect(':Setup:Setup:default');
        }
    }
}
