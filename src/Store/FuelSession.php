<?php

/*
 * This file is part of the Indigo Cart Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Store;

use Indigo\Cart\Cart;
use Fuel\Session\Manager;

/**
 * Fuel Session Store
 *
 * Save cart using Fuel Session
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelSession extends Session
{
    /**
     * @var Manager
     */
    protected $session;

    /**
     * @param Manager $session
     * @param string  $sessionKey
     */
    public function __construct(Manager $session, $sessionKey = 'cart')
    {
        $this->session = $session;

        parent::__construct($sessionKey);
    }

    /**
     * {@inheritdoc}
     */
    public function load(Cart $cart)
    {
        $items = $this->session->get($this->sessionKey . '.' . $cart->getId(), []);

        $cart->setItems($items);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Cart $cart)
    {
        $this->session->set($this->sessionKey . '.' . $cart->getId(), $cart->getItems());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Cart $cart)
    {
        return $this->session->delete($this->sessionKey . '.' . $cart->getId());
    }
}
