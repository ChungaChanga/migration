<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

abstract class UnitBase extends TestCase
{
    const REPOSITORY_SEVEN_VALUES = [
        'value1',
        'value2',
        'value3',
        'value4',
        'value5',
        'value6',
        'value7',
    ];

    const CUSTOMER_REPOSITORY_NINE_ENTITIES_STATES = [
        ['id' => 1],
        ['id' => 2],
        ['id' => 3],
        ['id' => 4],
        ['id' => 5],
        ['id' => 6],
        ['id' => 7],
        ['id' => 8],
        ['id' => 9],
    ];
}