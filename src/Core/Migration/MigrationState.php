<?php

namespace App\Core\Migration;

class MigrationState
{
    public function __construct(
        private string $uniqName,
        private int $currentPage,

    )
    {

    }
}