<?php

namespace App\UI\AuthModule\Logout;

use App\Core\BasePresenter;
use App\Services\ActionLogService;

class LogoutPresenter extends BasePresenter
{
    public function __construct(
        private readonly ActionLogService  $actionLogService,
    ){
    }
    public function actionDefault()
    {
        $user = $this->session->getSection('user');
        if ($user->permissionLevel >= 2)
        {
            $this->actionLogService->createActionLog(
                executorId: $user->userId,
                action: "User $user->username logged out from administration module",
            );
        }
        $user->remove();
        $this->flashMessage('You have been logged out!');
        $this->redirect('Login:default');
    }
}