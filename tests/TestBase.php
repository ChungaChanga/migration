<?php
declare(strict_types=1);

namespace App\Tests;

use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Woocommerce\Customers;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestBase extends KernelTestCase
{


    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }
}