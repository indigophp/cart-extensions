<?php

/*
 * This file is part of the Indigo Cart Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Money\Option;

use SebastianBergmann\Money\Money;

/**
 * Money Option interface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface OptionInterface
{
    /**
     * Return the value of the option
     *
     * @param  Money $price Price the calculation depends on
     * @return Money
     */
    public function getValue(Money $price);
}
