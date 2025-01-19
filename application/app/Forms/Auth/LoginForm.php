<?php

namespace App\Forms\Auth;

use Nette\Application\UI\Form;

class LoginForm
{
    public function create(): Form
    {
        $form = new Form();
        $form->addText('username', 'Username: ')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password: ')
            ->setRequired('Please enter your password');

        $form->addSubmit('send', 'Login');

        return $form;
    }
}