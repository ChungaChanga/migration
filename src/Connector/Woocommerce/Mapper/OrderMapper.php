<?php

namespace App\Connector\Woocommerce\Mapper;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Exception\ValidateEntityStateException;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;

class OrderMapper implements MapperReadInterface
{
    public function fromState(array $state): Order
    {
        $order = new Order();
        $order->setSourceId($state['Id']);
        $order->setTotal($state['total']);

        if (array_key_exists('line_items', $state)) {
            $this->addLineItems($order, $state['line_items']);
        }
        return $order;
    }

    public function validateState(array $state)
    {
        if (array_key_exists('line_items', $state) && !empty($state['line_items'])) {
            foreach ($state['line_items'] as $itemState) {
                if (!array_key_exists('product_data', $itemState) ||
                    empty($itemState['product_data']))
                {
                    throw new ValidateEntityStateException('product_data is required for line item', $state);
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
}