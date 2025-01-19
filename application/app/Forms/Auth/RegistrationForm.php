<?php

namespace App\Forms\Auth;

use Nette\Application\UI\Form;

class RegistrationForm
{
    public function create(): Form
    {
        $form = new Form();
        $form->addText('username', 'Username: ')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password: ')
            ->setRequired('Please enter your password')
            ->addRule($form::MinLength, 'Please enter at least 8 characters.', 8);

        $form->addPassword('password_repeat', 'Repeat password: ')
            ->setRequired('Please repeat your password')
            ->addRule(
                $form::Equal, 'Passwords do not match.', $form['password']
            );

        $form->addSubmit('send', 'Register');

        return $form;
    }
}