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
use SebastianBergmann\Money\Currency;

/**
 * Tests for Tax Option
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Option\Tax
 * @group              Cart
 * @group              Money
 * @group              Option
 */
class TaxTest extends AbstractOptionTest
{
    public function _before()
    {
        $this->option = new Tax(array(
            'id'    => 1,
            'name'  => 'Test option',
            'value' => new Money(200, new Currency('EUR')),
        ));
    }

    /**
     * @covers ::getValue
     */
    public function testValueMultiply()
    {
        $this->option->value = 100;

        $this->assertEquals(100, $this->option->getValue(new Money(100, new Currency('EUR')))->getAmount());
    }
}
