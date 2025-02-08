<?php

namespace App\Core;

use Nette\Database\Explorer;

class BaseModel
{
    protected Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }
}