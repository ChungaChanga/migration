<?php

namespace App\Tests\Unit;

class ConnectorIteratorTest
{
    public function partialResultProvider(): array
    {
        return [
            'allow partial result 0' => [
                [],
                0,//return count
                1,//pageStart
                10,//pageSize,
                true,//isAllowPartialResult
            ],
            'allow partial result 1' => [
                ['1'],
                1,
                1,
                10,
                true,//isAllowPartialResult
            ],
            'allow partial result 2' => [
                ['1', '2'],
                2,
                1,
                2,
                true,//isAllowPartialResult
            ],
            'disallow partial result 0' => [
                ['1'],
                0,
                1,
                10,
                false,//isAllowPartialResult
            ],
            'disallow partial result 1' =>  [
                ['1', '2'],
                2,
                1,
                2,
                false,//isAllowPartialResult
            ],
            'disallow partial result 2' => [
                ['1', '2'],
                2,
                1,
                2,
                false,//isAllowPartialResult
            ],
        ];
    }
}