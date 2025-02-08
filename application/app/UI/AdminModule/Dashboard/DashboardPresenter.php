<?php

namespace App\UI\AdminModule\Dashboard;

use App\Core\BasePresenter;
use App\Services\ActionLogService;

final class DashboardPresenter extends BasePresenter
{
    public function __construct(
        private readonly ActionLogService $actionLogService,
    ){
    }
    public function renderDefault(): void
    {
        $this->template->recentActivities = $this->actionLogService->getPageOfLatestActionLogs(10);
    }
}