<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 15:39
 */

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

/**
 * Cart item.
 *
 * @package Recruitment\Cart
 */
class Item
{
    /** @var Product */
    private $product;
    /** @var int */
    private $quantity;

    /**
     * Item constructor.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;

        $minimumQuantity = $this->product->getMinimumQuantity();
        if ($quantity < $minimumQuantity) {
            // uwaga: błędne użycie tego typu wyjątku w teście; powinno, zgodnie z dokumentacją PHP i logiką kodu,
            // być UnexpectedValueException (InvalidArgumentException jest do wyjątków nieprawidłowych typów,
            // a UnexpectedValueException do wyjątków nieprawidłowych wartości)
            throw new \InvalidArgumentException(
                'quantity too low: ' . $minimumQuantity . ' (positive quantity required)'
            );
        }

        $this->quantity = $quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Item
     */
    public function setQuantity(int $quantity): Item
    {
        $minimumQuantity = $this->product->getMinimumQuantity();
        if ($quantity < $minimumQuantity) {
            throw new QuantityTooLowException($quantity, $minimumQuantity);
        }

        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }

    /**
     * w j. ang. nie ma słowa 'brutto'
     *
     * prawidłowe określenia to - odpowiednio dla netto, brutto, tara - net, gross, tare
     *
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $product = $this->product;

        return (int)\round(
            $this->quantity * $product->getUnitPrice() * ($product->getTaxPercent() + 100) / 100
        );
    }
}
