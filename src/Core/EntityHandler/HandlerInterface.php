<?php

namespace App\Core\EntityHandler;

use SplObjectStorage;
interface HandlerInterface
{
    public function handle(SplObjectStorage $entities);
}