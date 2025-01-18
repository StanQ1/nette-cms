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
        
        if (!$this->configurationService->getConfigurationValue('is_ready_to_use')
            && (!$this->isLinkCurrent(':Admin:Setup:default')
            && !$this->isLinkCurrent(':Admin:Setup:setup'))
        ) {

            $this->redirect(':Admin:Setup:default');
        }
    }
}
