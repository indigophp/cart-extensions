<?php

namespace Indigo\Cart\Test\Money;

use Indigo\Cart\Money\Item;
use Indigo\Cart\Money\Option\Option;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Tests for Item
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Item
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    protected $item;

    protected $currency;

    protected function setUp()
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
     * @group  Cart
     */
    public function testPrice()
    {
        $this->assertEquals(100, $this->item->getPrice()->getAmount());
        $this->assertEquals(200 , $this->item->getPrice(true)->getAmount());
    }

    /**
     * @covers ::getSubtotal
     * @covers ::getPrice
     * @group  Cart
     */
    public function testSubtotal()
    {
        $this->assertEquals(100, $this->item->getSubtotal()->getAmount());
        $this->assertEquals($this->item->getPrice(true), $this->item->getSubtotal(true));
    }
}
