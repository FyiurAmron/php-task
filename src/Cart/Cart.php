<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 15:26
 */

namespace Recruitment\Cart;

use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

/**
 * Cart with items.
 *
 * @package Recruitment\Cart
 */
class Cart
{
    /** @var Item[] */
    private $items = [];

    /**
     * @param Product $product
     * @param int $quantity
     *
     * @return Cart
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        $id = $product->getId();

        if (\array_key_exists($id, $this->items)) {
            $item = $this->items[$id];
            $item->setQuantity($item->getQuantity() + $quantity);
        } else {
            $this->items[$id] = new Item($product, $quantity);
        }

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return Cart
     */
    public function removeProduct(Product $product): Cart
    {
        $id = $product->getId();

        unset($this->items[$id]);

        return $this;
    }

    public function removeAllProducts(): Cart
    {
        $this->items = [];

        return $this;
    }

    /**
     * @param Product $product
     * @param int $quantity
     *
     * @return Cart
     */
    public function setQuantity(Product $product, int $quantity): Cart
    {
        $id = $product->getId();

        if (!\array_key_exists($id, $this->items)) {
            $this->addProduct($product, $quantity);
        } else {
            $this->items[$id]->setQuantity($quantity);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int $nr
     *
     * @return Item
     */
    public function getItem(int $nr): Item
    {
        $array = \array_values($this->items);
        if (!\array_key_exists($nr, $array)) {
            throw new \OutOfBoundsException('item [' . $nr . '] not present in cart');
        }
        return $array[$nr];
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getTotalPrice();
        }
        return $sum;
    }

    /**
     * @param int $id
     *
     * @return Order
     */
    public function checkout(int $id): Order
    {
        $order = new Order($id, $this->items);

        $this->removeAllProducts();

        return $order;
    }
}
