<?php

/*
 * This file is part of the Indigo Cart Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Money;

use Indigo\Cart\Item as ParentItem;

/**
 * Money Item class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Item extends ParentItem
{
    /**
     * {@inheritdoc}
     */
    protected $struct = [
        'id' => [
            'required',
            'type' => ['integer', 'string'],
        ],
        'name' => [
            'required',
            'type' => 'string',
        ],
        'price' => [
            'required',
            'type' => 'SebastianBergmann\\Money\\Money',
        ],
        'quantity' => [
            'required',
            'type'       => 'integer',
            'numericMin' => 1,
        ],
        'option' => [
            'type' => 'Indigo\\Cart\\Option\\OptionInterface',
        ],
    ];

    /**
     * {@inheritdoc}
     *
     * @return Money
     */
    public function getPrice($option = false)
    {
        $price = $this->price;

        if ($option and isset($this->option)) {
            $option = $this->option->getValue($price);

            $price = $price->add($option);
        }

        return $price;
    }

    /**
     * {@inheritdoc}
     *
     * @return Money
     */
    public function getSubtotal($option = false)
    {
        $price = $this->getPrice($option);

        return $price->multiply($this->quantity);
    }
}
