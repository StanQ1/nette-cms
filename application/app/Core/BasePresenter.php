<?php

namespace App\Core;

use Nette\Application\UI\Presenter;
use App\Model\ConfigurationService;

class BasePresenter extends Presenter
{
    protected ConfigurationService $configurationService;

    public function __construct(ConfigurationService $configurationService)
    {
        parent::__construct();
        $this->configurationService = $configurationService;
    }

    protected function startup(): void
    {
        parent::startup();
        
        if (!$this->configurationService->getConfigurationValue('is_ready_to_use')
            && (!$this->isLinkCurrent(':Admin:Setup:default')
            && !$this->isLinkCurrent(':Admin:Setup:setup'))
        ) {

            $this->redirect(':Admin:Setup:default');
        }
    }
}
