<?php

namespace App\Repository\Interface;

interface RepositoryReadInterface
{
    public function fetch(int $start, int $end): array;
}