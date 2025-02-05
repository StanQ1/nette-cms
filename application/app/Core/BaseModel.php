<?php

namespace App\Core;

use Nette\DI\Attributes\Inject;

class BaseModel
{
    #[Inject]
    protected \Nette\Database\Explorer $database;
}