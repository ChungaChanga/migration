<?php

namespace App;

enum EntityTransferStatus: string
{
    case Done = 'done';
    case Processing = 'processing';
    case Error = 'error';
}