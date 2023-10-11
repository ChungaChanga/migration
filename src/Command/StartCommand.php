<?php

declare(strict_types=1);

namespace App\Command;

require 'vendor/autoload.php';


use App\Connector\WoocommerceApiRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// название команды - это то, что пользователь вводит после "bin/console"
#[AsCommand(name: 'migration:start')]
class StartCommand extends Command
{
    public function __construct(
        private HttpClientInterface $client,
    ){
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connector = new WoocommerceApiRepository($this->client);
        $customers = $connector->getCustomers(5);
        var_dump($customers);
        return Command::SUCCESS;
    }
}