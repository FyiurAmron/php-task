<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 15:29
 */

namespace Recruitment\Cart\Exception;

/**
 * Class QuantityTooLowException
 *
 * @package Recruitment\Cart\Exception
 */
class QuantityTooLowException extends \UnexpectedValueException
{

    /**
     * QuantityTooLowException constructor.
     *
     * @param int $quantity
     * @param int $minimumQuantity
     */
    public function __construct(int $quantity, int $minimumQuantity)
    {
        parent::__construct('quantity too low: ' . $quantity . ' (at least ' . $minimumQuantity . ' required)');
    }
}
