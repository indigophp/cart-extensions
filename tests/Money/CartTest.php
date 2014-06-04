<?php

namespace Indigo\Cart\Test\Money;

use Indigo\Cart\Money\Cart;
use Indigo\Cart\Money\Item;
use Indigo\Cart\Money\Option\Collection;
use Indigo\Cart\Money\Option\Option;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Tests for Cart
 *
 * @author  Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass  Indigo\Cart\Money\Cart
 */
class CartTest extends \PHPUnit_Framework_TestCase
{
    protected $cart;

    protected $item;

    protected $currency;

    protected function setUp()
    {
        $this->currency = new Currency('EUR');
        $this->cart = new Cart('cart_01', $this->currency);

        $this->item = new Item(
            array(
                'id'       => 1,
                'name'     => 'Some Product',
                'price'    => new Money(100, $this->currency),
                'quantity' => 1,
                'option'  => new Collection(array(
                    new Option(array(
                        'id'    => 1,
                        'name'  => 'Test Option',
                        'value' => new Money(100, $this->currency),
                    )),
                )),
            )
        );

        $this->cart->add($this->item);
    }

    /**
     * @covers ::getCurrency
     * @covers ::setCurrency
     * @group  Cart
     */
    public function testCurrency()
    {
        $this->assertSame($this->currency, $this->cart->getCurrency());
        $this->assertSame($this->cart, $this->cart->setCurrency($this->currency));
    }

    /**
     * @covers ::getTotal
     * @group  Cart
     */
    public function testTotal()
    {
        $this->assertEquals(100, $this->cart->getTotal()->getAmount());
        $this->assertEquals(200, $this->cart->getTotal(true)->getAmount());
    }

    /**
     * @covers ::getQuantity
     * @group  Cart
     */
    public function testQuantity()
    {
        $this->assertEquals(1, $this->cart->getQuantity());
    }
}
