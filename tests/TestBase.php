<?php
declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestBase extends KernelTestCase
{
    private string $baseDir;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->baseDir = __DIR__;
        parent::__construct($name, $data, $dataName);
    }

    protected function getFakeData(string $entityType, string $sourceType)
    {
        if ('customers' === $entityType) {
            if ('woocommerce' === $sourceType) {
                return $this->getFakeWoocommerceCustomers();
            }
        }
    }

    private function getFakeWoocommerceCustomers()
    {
        return  [
            [
                'id' => 1,
                'email' => 'ritav@test.ru',
                'first_name' => 'Rita',
                'last_name' => 'Vrataski'
            ],
            [
                'id' => 1377897,
                'email' => 'johnv@test.ru',
                'first_name' => 'John',
                'last_name' => 'Wick'
            ],
        ];
    }

    private function getFakeMagentoCustomers()
    {
        return [
            [
                'email' => 'ritav@test.ru',
                'firstname' => 'Rita',
                'lastname' => 'Vrataski'
            ],
            [
                'email' => 'johnv@test.ru',
                'firstname' => 'John',
                'lastname' => 'Wick'
            ],
        ];
    }
}