<?php

/*
 * This file is part of the Money Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Item;

use Indigo\Cart\Item;
use Indigo\Cart\TotalCalculator;

/**
 * Money Item
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Money implements Item, TotalCalculator
{
    use \Indigo\Cart\Quantity;

    /**
     * Unique identifier
     *
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Money\Money
     */
    private $price;

    /**
     * @param string       $name
     * @param \Money\Money $price
     * @param integer      $quantity
     * @param mixed        $id
     */
    public function __construct($name, \Money\Money $price, $quantity, $id = null)
    {
        $this->setQuantity($quantity);

        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        if ($this->id === null) {
            $this->id = $this->hashId();
        }

        return $this->id;
    }

    /**
     * Generates a hash for the item
     *
     * @return string
     */
    private function hashId()
    {
        return md5(serialize([$this->name, $this->price]));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubtotal()
    {
        return $this->price->multiply($this->quantity);
    }

    /**
     * {@inheritdoc}
     */
    public function calculateTotal($total = null)
    {
        if (is_null($total)) {
            return $this->getSubtotal();
        }

        return $total->add($this->getSubtotal());
    }
}
