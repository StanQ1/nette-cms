<?php

namespace App\Core;

class BaseModel
{
    public function __construct(
        protected \Nette\Database\Explorer $database
    ){
    }
}