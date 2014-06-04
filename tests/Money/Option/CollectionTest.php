<?php

namespace Indigo\Cart\Test\Money\Option;

use Indigo\Cart\Money\Item;
use Indigo\Cart\Money\Option\Collection;
use Indigo\Cart\Money\Option\Option;
use Indigo\Cart\Money\Option\Tax;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Tests for Collection Option
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Money\Option\Collection
 */
class CollectionTest extends AbstractOptionTest
{
    protected $mock;

    protected function setUp()
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
     * @covers ::add
     * @group  Cart
     */
    public function testAdd()
    {
        $option = $this->mock;

        $this->option->setContents(array());
        $id = $option->getId();

        $this->assertFalse($this->option->has($id));

        $this->option->add($option);

        $this->assertTrue($this->option->has($id));
    }

    /**
     * @covers ::getValueOfType
     * @group  Cart
     */
    public function testValueOfType()
    {
        $this->assertEquals(200, $this->option->getValueOfType(new Money(100, new Currency('EUR')), new Type('Indigo\\Cart\\Money\\Option\\OptionInterface'))->getAmount());
    }
}