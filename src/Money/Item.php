<?php

/*
 * This file is part of the Indigo Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Money;

use Indigo\Cart;
use SebastianBergmann\Money\Money;

/**
 * Money Item class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Item extends Cart\Item
{
    /**
     * {@inheritdocs}
     */
    protected $struct = array(
        'id' => array(
            'required',
            'type' => array('integer', 'string'),
        ),
        'name' => array(
            'required',
            'type' => 'string',
        ),
        'price' => array(
            'required',
            'type' => 'SebastianBergmann\\Money\\Money',
        ),
        'quantity' => array(
            'required',
            'type'       => 'integer',
            'numericMin' => 1,
        ),
        'option' => array(
            'type' => 'Indigo\\Cart\\Money\\OptionInterface'
        ),
    );

    /**
     * {@inheritdocs}
     *
     * @return Money
     */
    public function getPrice($option = false)
    {
        $price = $this->price;

        if ($option and isset($this->data['option'])) {
            $option = $this->option->getValue($price);

            $price = $price->add($option);
        }

        return $price;
    }

    /**
     * {@inheritdocs}
     *
     * @return Money
     */
    public function getSubtotal($option = false)
    {
        $price = $this->getPrice($option);

        return $price->multiply($this->quantity);
    }
}