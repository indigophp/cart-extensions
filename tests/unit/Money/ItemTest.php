<?php

/*
 * This file is part of the Indigo Cart Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Money;

use Indigo\Cart\Money\Option\Option;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;
use Codeception\TestCase\Test;

/**
 * Tests for Item
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Item
 * @group              Cart
 * @group              Money
 */
class ItemTest extends Test
{
    protected $item;

    protected $currency;

    protected function _before()
    {
        $this->currency = new Currency('EUR');

        $this->item = new Item(array(
            'id'       => 1,
            'name'     => 'Some Product',
            'price'    => new Money(100, $this->currency),
            'quantity' => 1,
            'option'  => new Option(array(
                'id'    => 1,
                'name'  => 'Test Option',
                'value' => new Money(100, $this->currency),
            )),
        ));
    }

    /**
     * @covers ::getPrice
     */
    public function testPrice()
    {
        $this->assertEquals(100, $this->item->getPrice()->getAmount());
        $this->assertEquals(200 , $this->item->getPrice(true)->getAmount());
    }

    /**
     * @covers ::getSubtotal
     * @covers ::getPrice
     */
    public function testSubtotal()
    {
        $this->assertEquals(100, $this->item->getSubtotal()->getAmount());
        $this->assertEquals($this->item->getPrice(true), $this->item->getSubtotal(true));
    }
}
