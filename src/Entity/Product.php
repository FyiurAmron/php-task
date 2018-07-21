<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 15:25
 */

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;

/**
 * Product entity.
 *
 * @package Recruitment\Entity
 */
class Product
{
    public const ALLOWED_TAX_PERCENTAGES = [
        0,
        5,
        8,
        23,
    ];

    /** @var null|string */
    private $name;
    /** @var int|null */
    private $id;
    /** @var int|null */
    private $minimumQuantity;
    /** @var int|null */
    private $unitPrice;
    /** @var int|null */
    private $taxPercent;

    /**
     * Product constructor.
     *
     * @param null|string $name
     * @param int|null $id
     * @param int|null $minimumQuantity
     * @param int|null $unitPrice
     * @param int|null $taxPercent
     */
    public function __construct(
        ?string $name = null,
        ?int $id = null,
        ?int $minimumQuantity = 1,
        ?int $unitPrice = null,
        ?int $taxPercent = null
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->minimumQuantity = $minimumQuantity;
        $this->unitPrice = $unitPrice;
        $this->taxPercent = $taxPercent;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getMinimumQuantity(): ?int
    {
        return $this->minimumQuantity;
    }

    /**
     * @return int|null
     */
    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    /**
     * @return int|null
     */
    public function getTaxPercent(): ?int
    {
        return $this->taxPercent;
    }

    /**
     * @param null|string $name
     *
     * @return Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $minimumQuantity
     *
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): Product
    {
        if ($minimumQuantity <= 0) {
            // uwaga: błędne użycie tego typu wyjątku w teście; powinno, zgodnie z dokumentacją PHP i logiką kodu,
            // być UnexpectedValueException (InvalidArgumentException jest do wyjątków nieprawidłowych typów,
            // a UnexpectedValueException do wyjątków nieprawidłowych wartości)
            throw new \InvalidArgumentException(
                'quantity too low: ' . $minimumQuantity . ' (positive quantity required)'
            );
        }

        $this->minimumQuantity = $minimumQuantity;

        return $this;
    }

    /**
     * @param int $unitPrice
     *
     * @return Product
     */
    public function setUnitPrice(int $unitPrice): Product
    {
        if ($unitPrice <= 0) {
            throw new InvalidUnitPriceException($unitPrice, 'positive price required');
        }

        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @param int|null $taxPercent
     *
     * @return Product
     */
    public function setTaxPercent(?int $taxPercent): Product
    {
        if (!\in_array($taxPercent, self::ALLOWED_TAX_PERCENTAGES, true)) {
            throw new \UnexpectedValueException('tax percentage: ' . $taxPercent . ' is not allowed');
        }

        $this->taxPercent = $taxPercent;

        return $this;
    }
}
