<?php

namespace Indigo\Cart\Test\Money\Option;

use Indigo\Cart\Money\Option\Option;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Tests for Option
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Option\Option
 */
class OptionTest extends AbstractOptionTest
{
    public function setUp()
    {
        $this->option = new Option(array(
            'id'    => 1,
            'name'  => 'Test option',
            'value' => new Money(200, new Currency('EUR'))
        ));
    }
}
