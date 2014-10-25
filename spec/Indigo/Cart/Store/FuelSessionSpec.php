<?php

namespace spec\Indigo\Cart\Store;

use Indigo\Cart\Cart;
use Indigo\Cart\Stub\SessionManager as Manager;
use Fuel\Session\DataContainer;
use PhpSpec\ObjectBehavior;

class FuelSessionSpec extends ObjectBehavior
{
    protected $session;

    function let(Manager $session)
    {
        $this->beConstructedWith($session);

        $this->session = $session;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Cart\Store\FuelSession');
        $this->shouldHaveType('Indigo\Cart\Store\Session');
        $this->shouldHaveType('Indigo\Cart\Store');
    }

    function it_should_have_a_session_key()
    {
        $this->beConstructedWith($this->session, 'SESSION_KEY');

        $this->getSessionKey()->shouldReturn('SESSION_KEY');
    }

    function it_should_load_a_cart(Cart $cart)
    {
        $this->session->get('cart.cart', [])->shouldBeCalled()->willReturn([]);
        $cart->getId()->willReturn('cart');
        $cart->setItems([])->shouldBeCalled();

        $this->load($cart)->shouldReturn(true);
    }

    function it_should_save_a_cart(Cart $cart)
    {
        $this->session->set('cart.cart', [])->shouldBeCalled();
        $cart->getId()->willReturn('cart');
        $cart->getItems()->willReturn([]);

        $this->save($cart)->shouldReturn(true);
    }

    function it_should_delete_a_cart(Cart $cart)
    {
        $this->session->delete('cart.cart')->shouldBeCalled()->willReturn(true);
        $cart->getId()->willReturn('cart');

        $this->delete($cart)->shouldReturn(true);
    }

    function it_should_load_an_existing_cart(Cart $cart)
    {
        $this->session->get('cart.cart', [])->shouldBeCalled()->willReturn([]);
        $this->session->set('cart.cart', [])->shouldBeCalled();
        $cart->getId()->willReturn('cart');
        $cart->getItems()->willReturn([]);
        $cart->setItems([])->shouldBeCalled();

        $this->save($cart)->shouldReturn(true);

        $this->load($cart)->shouldReturn(true);
    }
}
