<?php

namespace App\Tests\Fixtures\Magento;

use App\Tests\Fixtures\ProductsInterface;

class Products implements ProductsInterface
{

    public function first(): array
    {
        return [
            'id' => 1,
            'sku' => 'sku1',
        ];
    }

    public function second(): array
    {
        return [
            'id' => 2,
            'sku' => 'sku2',
        ];
    }

    public function third(): array
    {
        return [
            'id' => 3,
            'sku' => 'sku3',
        ];
    }
}