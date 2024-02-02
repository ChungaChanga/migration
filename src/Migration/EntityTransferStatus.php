<?php

namespace App\Migration;

enum EntityTransferStatus: string
{
    case Done = 'done';
    case Processing = 'processing';
    case Error = 'error';
}