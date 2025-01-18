<?php

namespace App\UI\AdminModule\Dashboard;

use App\Core\BasePresenter;
use App\Services\ConfigurationService;
use Nette\Application\UI\Presenter;

final class DashboardPresenter extends BasePresenter
{
    public function renderDefault(): void
    {
        $sessionSection = $this->getSession('user');

        if (isset($sessionSection->userId)) {
            // Сесія існує, і користувач залогінений
            $userId = $sessionSection->userId;
            $username = $sessionSection->username;
            $permissionLevel = $sessionSection->permissionLevel;

            // Наприклад, можна вивести дані
            echo "User ID: $userId, Username: $username, PermissionLevel: $permissionLevel";
        } else {
            // Сесія не створена, користувач не залогінений
            echo "Користувач не залогінений.";
        }

//        $this->getSession('user')->remove();
    }
}