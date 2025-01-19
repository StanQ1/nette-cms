<?php

namespace App\Core;

use App\Services\ConfigurationService;
use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
    public function __construct(protected ConfigurationService $configurationService)
    {
        parent::__construct();
    }

    protected function startup(): void
    {
        parent::startup();

        $appIsReady = $this->configurationService->getConfigurationValue('is_ready_to_use');

        if ($appIsReady
            && $this->isModuleCurrent('Admin')
            && $this->getSession()->getSection('user')->get('permissionLevel') < 2
        ) {
            $this->redirect(':Front:Home:default');
        }

        if (
            !$appIsReady && !$this->isModuleCurrent('Setup')
        ) {

            $this->redirect(':Setup:Setup:default');
        }
    }
}
