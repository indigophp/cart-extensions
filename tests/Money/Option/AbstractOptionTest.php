<?php

namespace Indigo\Cart\Test\Money\Option;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

abstract class AbstractOptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OptionInterface
     */
    protected $option;

    /**
     * @covers ::getValue
     * @group  Cart
     */
    public function testValue()
    {
        $this->assertEquals(200, $this->option->getValue(new Money(100, new Currency('EUR')))->getAmount());
    }
}
