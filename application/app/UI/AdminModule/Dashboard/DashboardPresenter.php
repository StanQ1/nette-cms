<?php

namespace App\UI\AdminModule\Dashboard;

use App\Model\ConfigurationService;
use Nette\Application\UI\Presenter;

final class DashboardPresenter extends Presenter
{
    public function __construct(
        private ConfigurationService $configurationService
    ){
    }
    
    public function renderDefault(): void
    {
        
    }
}