<?php

namespace App\UI\AuthModule\Logout;

use App\Core\BasePresenter;

class LogoutPresenter extends BasePresenter
{
    public function actionDefault()
    {
        $this->session->getSection('user')->remove();
        $this->flashMessage('You have been logged out!');
        $this->redirect('Login:default');
    }
}