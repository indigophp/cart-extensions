<?php

namespace Indigo\Cart\Test\Money\Option;

use Indigo\Cart\Money\Option\Tax;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Tests for Tax Option
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Option\Tax
 */
class TaxTest extends AbstractOptionTest
{
    public function setUp()
    {
        $this->option = new Tax(array(
            'id'    => 1,
            'name'  => 'Test option',
            'value' => new Money(200, new Currency('EUR')),
        ));
    }

    /**
     * @covers ::getValue
     * @group  Cart
     */
    public function testValueMultiply()
    {
        $this->option->value = 100;

        $this->assertEquals(100, $this->option->getValue(new Money(100, new Currency('EUR')))->getAmount());
    }
}
