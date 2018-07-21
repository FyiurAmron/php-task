<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 15:26
 */

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

/**
 * Order entity.
 *
 * @package Recruitment\Entity
 */
class Order
{
    /** @var int */
    private $id;
    /** @var Item[] */
    private $items;

    /**
     * Order constructor.
     *
     * @param int $id
     * @param Item[] $items
     */
    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = \array_values($items);
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

    private static function getItemToArray(Item $item): array
    {
        return [
            'id' => $item->getProduct()->getId(),
            'quantity' => $item->getQuantity(),
            'total_price' => $item->getTotalPrice()
        ];
    }

    /**
     * @return array
     */
    private function getItemsToArray(): array
    {
        return \array_map(function ($x) {
            return self::getItemToArray($x);
        }, $this->items);
    }

    public function getDataForView(): array
    {
        return [
            'id' => $this->id,
            'items' => $this->getItemsToArray(),
            'total_price' => $this->getTotalPrice(),
        ];
    }
}
