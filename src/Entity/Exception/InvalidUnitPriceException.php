<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: vax
 * Date: 21.07.18
 * Time: 15:28
 */

namespace Recruitment\Entity\Exception;

/**
 * Class InvalidUnitPriceException
 *
 * @package Recruitment\Entity\Exception
 */
class InvalidUnitPriceException extends \UnexpectedValueException
{

    /**
     * InvalidUnitPriceException constructor.
     *
     * @param int $givenPrice
     * @param string|null $message
     */
    public function __construct(int $givenPrice, string $message = null)
    {
        parent::__construct('invalid unit price: ' . $givenPrice
            . (($message === null) ? '' : ' (' . $message . ')'));
    }
}
