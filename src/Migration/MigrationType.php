<?php

namespace App\Migration;

enum MigrationType: string
{
    case Customers = 'customers';
    case Orders = 'orders';
    case Products = 'products';
}
