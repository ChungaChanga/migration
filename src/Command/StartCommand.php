<?php

declare(strict_types=1);

namespace App\Command;

require 'vendor/autoload.php';


use App\Connector\Memory\Connector\CustomerConnector as MemoryCustomerConnector;
use App\Connector\WoocommerceDto\Connector\Connector as WoocommerceCustomerConnector;
use App\Core\Connection\Connection;
use App\Core\Migration\TransferStrategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// название команды - это то, что пользователь вводит после "bin/console"
#[AsCommand(name: 'migration:start')]
class StartCommand extends Command
{
    public function __construct(private HttpClientInterface $client)
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $woocommerceConnector = new WoocommerceCustomerConnector(
            $this->client,
            $_ENV['WOOCOMMERCE_API_URL_CUSTOMERS'],
            $_ENV['WOOCOMMERCE_API_KEY'],
            $_ENV['WOOCOMMERCE_API_SECRET']
        );
        $connection = new Connection(
            $woocommerceConnector,
            new MemoryCustomerConnector()
        );

        $transferStrategy = new TransferStrategy(
            $connection,
            1,
            9,
            1,
        );

        $transferStrategy->start();

        $iterator = $connection->getDestinationConnector()->getRepository()
            ->createAwaitingPageIterator(1, 2);

        foreach ($iterator as $k => $v) {
            if ($k > 4) {
                break;
            }
            echo '-------- ' . $k . PHP_EOL;
            print_r($v);
        }

        return Command::SUCCESS;
    }
}