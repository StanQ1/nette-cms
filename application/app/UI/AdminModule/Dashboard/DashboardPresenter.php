<?php

namespace App\UI\AdminModule\Dashboard;

use App\Core\BasePresenter;

final class DashboardPresenter extends BasePresenter
{
    public function renderDefault(): void
    {
        $this->template->username = $this->getSession('user')->username;
    }
}