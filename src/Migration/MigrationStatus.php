<?php

namespace App\Migration;

enum MigrationStatus
{
    case Pause;
    case Run;
}