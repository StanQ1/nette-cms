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
        $logsArray = $this->actionLogService->getPageOfLatestActionLogs(10);
        $this->template->recentActivities = array_reverse($logsArray);
    }

    public function renderMonitoring(): void
    {
        $logsArray = $this->actionLogService->getPageOfLatestActionLogs();
        $this->template->recentActivities = array_reverse($logsArray);
    }
}