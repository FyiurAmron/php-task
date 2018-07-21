<?php

declare(strict_types=1);

namespace Recruitment\Tests\Cart;

use PHPUnit\Framework\TestCase;
use Recruitment\Cart\Cart;
use Recruitment\Entity\Product;
use Recruitment\Tests\Entity\ProductTest;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function itAddsOneProduct(): void
    {
        $product = ProductTest::buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertEquals($product, $cart->getItem(0)->getProduct());
    }

    /**
     * @test
     */
    public function itRemovesExistingProduct(): void
    {
        $product1 = ProductTest::buildTestProduct(1, 15000);
        $product2 = ProductTest::buildTestProduct(2, 10000);

        $cart = new Cart();
        $cart->addProduct($product1, 1)
            ->addProduct($product2, 1);
        $cart->removeProduct($product1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(10000, $cart->getTotalPrice());
        $this->assertEquals($product2, $cart->getItem(0)->getProduct());
    }

    /**
     * @test
     */
    public function itIncreasesQuantityWhenAddingAnExistingProduct(): void
    {
        $product = ProductTest::buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1)
            ->addProduct($product, 2);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(45000, $cart->getTotalPrice());
    }

    /**
     * @test
     */
    public function itUpdatesQuantityOfAnExistingItem(): void
    {
        $product = ProductTest::buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1)
            ->setQuantity($product, 2);

        $this->assertEquals(30000, $cart->getTotalPrice());
        $this->assertEquals(2, $cart->getItem(0)->getQuantity());
    }

    /**
     * @test
     */
    public function itAddsANewItemWhileSettingQuantityForNonExistentItem(): void
    {
        $product = ProductTest::buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->setQuantity($product, 1);

        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertCount(1, $cart->getItems());
    }

    /**
     * @test
     * @dataProvider getNonExistentItemIndexes
     * @expectedException \OutOfBoundsException
     *
     * @param int $index
     */
    public function itThrowsExceptionWhileGettingNonExistentItem(int $index): void
    {
        $product = ProductTest::buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1);
        $cart->getItem($index);
    }

    /**
     * @test
     */
    public function removingNonExistentItemDoesNotRaiseException(): void
    {
        $cart = new Cart();
        $cart->addProduct(ProductTest::buildTestProduct(1, 15000));
        $cart->removeProduct(new Product());

        $this->assertCount(1, $cart->getItems());
    }

    /**
     * @test
     */
    public function itClearsCartAfterCheckout(): void
    {
        $cart = new Cart();
        $cart->addProduct(ProductTest::buildTestProduct(1, 15000, 23));
        $cart->addProduct(ProductTest::buildTestProduct(2, 10000), 2);

        $cart->checkout(7);

        $this->assertCount(0, $cart->getItems());
        $this->assertEquals(0, $cart->getTotalPrice());
    }

    public function getNonExistentItemIndexes(): array
    {
        return [
            [PHP_INT_MIN],
            [-1],
            [1],
            [PHP_INT_MAX],
        ];
    }
}
