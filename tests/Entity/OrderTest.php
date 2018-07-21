<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 19:45
 */

namespace Recruitment\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Recruitment\Cart\Cart;
use Recruitment\Entity\Order;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function itProvidesValidDataForView(): void
    {
        $cart = new Cart();
        $cart->addProduct(ProductTest::buildTestProduct(1, 15000, 23));
        $cart->addProduct(ProductTest::buildTestProduct(2, 10000), 2);

        $order = $cart->checkout(7);

        /** @noinspection UnnecessaryAssertionInspection */
        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(
            [
                'id' => 7,
                'items' => [
                    [
                        'id' => 1,
                        'quantity' => 1,
                        'total_price' => 15000,
                        'tax_percent' => 23,
                        'total_price_gross' => 18450,
                    ],
                    [
                        'id' => 2,
                        'quantity' => 2,
                        'total_price' => 20000,
                        'tax_percent' => 0,
                        'total_price_gross' => 20000,
                    ],
                ],
                'total_price' => 35000,
                'total_price_gross' => 38450,
            ],
            $order->getDataForView()
        );
    }
}