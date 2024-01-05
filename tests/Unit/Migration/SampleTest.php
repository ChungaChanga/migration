<?php

namespace App\Tests\Unit\Migration;

use App\Test1;
use App\Tests\TestBase;

class SampleTest extends TestBase
{
    public function testMock()
    {
        $this->markTestSkipped('just skipped');
        $mock = $this->getMockBuilder(Test1::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->onlyMethods(['getValue5', 'getValue67'])
            ->getMock();
        $mock->method('getValue5')
            ->will($this->returnValue(new \stdClass()));
        $mock->method('getValue67')
            ->will($this->returnValue(new \stdClass()));


        $this->assertInstanceOf(4545, $mock->getValue5());
        $this->assertEquals(67, $mock->getValue67());
    }
}