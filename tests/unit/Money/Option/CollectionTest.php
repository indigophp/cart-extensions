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

use Indigo\Cart\Money\Item;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Tests for Collection Option
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Option\Collection
 * @group              Cart
 * @group              Money
 * @group              Option
 */
class CollectionTest extends AbstractOptionTest
{
    protected $mock;

    protected function _before()
    {
        $this->option = new Collection;

        $this->mock = new Option(array(
            'id'    => 1,
            'name'  => 'Test Option',
            'value' => new Money(200, new Currency('EUR')),
        ));

        $this->option->add($this->mock);
    }

    /**
     * @covers ::getValueOfType
     */
    public function testValueOfType()
    {
        $this->assertEquals(200, $this->option->getValueOfType(new Money(100, new Currency('EUR')), new Type('Indigo\\Cart\\Option\\OptionInterface'))->getAmount());
    }

    /**
     * @covers            ::getValueOfType
     * @expectedException InvalidArgumentException
     */
    public function testValueOfTypeFailure()
    {
        $this->option->getValueOfType(null, new Type('Indigo\\Cart\\Option\\OptionInterface'));
    }
}
