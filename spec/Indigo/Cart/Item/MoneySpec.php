<?php

namespace spec\Indigo\Cart\Item;

use Money\Money;
use PhpSpec\ObjectBehavior;

class MoneySpec extends ObjectBehavior
{
    protected $price;

    function let()
    {
        $this->price = Money::USD(1);
        $this->beConstructedWith('Item', $this->price, 1, '_ITEM_');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Cart\Item\Money');
        $this->shouldHaveType('Indigo\Cart\TotalCalculator');
        $this->shouldHaveType('Indigo\Cart\Item');
    }

    function it_should_have_an_id()
    {
        $this->beConstructedWith('Item', $this->price, 1);
        $this->getId()->shouldBeString();
    }

    function it_should_allow_to_have_an_id()
    {
        $this->getId()->shouldReturn('_ITEM_');
    }

    function it_should_have_name()
    {
        $this->getName()->shouldReturn('Item');
    }

    function it_should_have_price()
    {
        $this->getPrice()->shouldReturn($this->price);
    }

    function it_should_have_subtotal()
    {
        $subtotal = $this->getSubtotal();
        $subtotal->shouldHaveType('Money\Money');
    }

    function it_should_calculate_total()
    {
        $this->calculateTotal()->shouldHaveType('Money\Money');
    }

    function it_should_calculate_total_from_passed_value()
    {
        $this->calculateTotal(Money::USD(1))->shouldHaveType('Money\Money');
    }
}
