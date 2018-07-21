<?php

declare(strict_types=1);

namespace Recruitment\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Recruitment\Entity\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     * @expectedException \Recruitment\Entity\Exception\InvalidUnitPriceException
     */
    public function itThrowsExceptionForInvalidUnitPrice(): void
    {
        $product = new Product();
        $product->setUnitPrice(0);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionForInvalidMinimumQuantity(): void
    {
        $product = new Product();
        $product->setMinimumQuantity(0);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function itThrowsExceptionForInvalidTaxPercentage(): void
    {
        $product = new Product();
        $product->setTaxPercent(22);
    }

    public static function buildTestProduct(int $id, int $price, int $taxPercent = 0): Product
    {
        return (new Product())->setId($id)->setUnitPrice($price)->setTaxPercent($taxPercent);
    }
}
