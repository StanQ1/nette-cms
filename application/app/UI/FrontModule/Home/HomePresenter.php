<?php

declare(strict_types=1);

namespace App\UI\FrontModule\Home;

use App\Core\BasePresenter;

final class HomePresenter extends BasePresenter
{
    // public function __construct(
    //     private ConfigurationService $configurationService
    //     ){
    //     $this->onStartup[] = function() {
    //         if ($this->configurationService->getAppIsReadyState() == false)
    //         {
    //             $this->redirect(':Admin:Setup:default');
    //         }
    //     };
    // }

    public function renderDefault(): void
    {
        
    }
}
