<?php

namespace App\Connector\Woocommerce\Mapper;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Exception\InvalidStateException;
use App\Contract\Connector\Mapper\MapperReadInterface;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use \UnexpectedValueException;

class OrderMapper implements MapperReadInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }
    public function fromState(array $state): Order
    {
        $order = new Order();
        $order->setSourceId($state['id']);
        $order->setTotal($state['total']);
        $order->setCustomer(
            $this->getCustomerByCustomerId($state['customer_id'])
        );

        if (array_key_exists('line_items', $state)) {
            $this->addLineItems($order, $state['line_items']);
        }
        return $order;
    }

    public function validateState(array $state): void
    {
        if (array_key_exists('line_items', $state) && !empty($state['line_items'])) {
            foreach ($state['line_items'] as $itemState) {
                if (!array_key_exists('product_data', $itemState) ||
                    empty($itemState['product_data']))
                {
                    throw new InvalidStateException('product_data is required for line item');
                }
            }
        }
    }

    private function addLineItems(Order $order, array $lineItemsState): void
    {
        if (empty($lineItemsState)) {
            return;
        }
        foreach ($lineItemsState as $itemState) {
            $item = new OrderItem();
            $product = $this->getProductFromState($itemState['product_data']);
            $item->setProduct($product);
        }
    }

    private function getProductFromState(array $state): Product
    {
        $product = new Product();
        $product->setSourceId($state['id']);
        $product->setSku($state['sku']);
    }

    /**
     * @param int $customerId
     * @return Customer
     * @throws UnexpectedValueException
     */
    private function getCustomerByCustomerId(int $customerId): Customer
    {
        /**
         * @var CustomerRepository $customerRepository
         */
        $customerRepository = $this->entityManager->getRepository(Customer::class);
        $customer = $customerRepository->findOneBySourceId($customerId);
        if (is_null($customer)) {
            throw new UnexpectedValueException('The customer must exist');
        }
        return $customer;
    }
}