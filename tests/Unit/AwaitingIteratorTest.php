<?php

namespace App\Tests\Unit;

use App\Connector\Memory\Repository\CustomerRepository;
use App\Core\Iterator\AwaitingIterator;
use App\Tests\UnitBase;

class AwaitingIteratorTest extends UnitBase
{
    public function testCurrent()
    {
        $batchSize = 2;
        $repository = new CustomerRepository();
        $repository->create(self::REPOSITORY_SEVEN_VALUES);
        $iterator = new AwaitingIterator($repository, $batchSize);

        foreach ($iterator as $k => $v) {
            switch ($k) {
                case 0:
                    $this->assertEquals('value1', $v[0]);
                    $this->assertEquals('value2', $v[1]);
                break;
                case 1:
                    $this->assertEquals('value3', $v[0]);
                    $this->assertEquals('value4', $v[1]);
                    break;
                case 2:
                    $this->assertEquals('value5', $v[0]);
                    $this->assertEquals('value6', $v[1]);
                    break;
                case 3:
                    $this->assertEquals('value7', $v[0]);
                    $this->assertArrayNotHasKey(1, $v);
                    break 2;
            }
        }
    }

    public function testNext()
    {
        $batchSize = 2;
        $repository = new CustomerRepository();
        $repository->create(self::REPOSITORY_SEVEN_VALUES);
        $iterator = new AwaitingIterator($repository, $batchSize);

        for ($i = 0; $i < 10; $i++) {
            $iterator->current();
            $iterator->next();
        }

        $this->assertEquals(3, $iterator->key());
    }
}