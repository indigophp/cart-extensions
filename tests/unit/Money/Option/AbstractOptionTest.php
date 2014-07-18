<?php

namespace Indigo\Cart\Money\Option;

use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;
use Codeception\TestCase\Test;

abstract class AbstractOptionTest extends Test
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

    /**
     * @covers            ::getValue
     * @expectedException InvalidArgumentException
     * @group             Cart
     */
    public function testValueFailure()
    {
        $this->option->getValue(null);
    }
}
