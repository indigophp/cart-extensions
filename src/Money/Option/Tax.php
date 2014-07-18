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

use Indigo\Cart\Option\Tax as ParentTax;
use SebastianBergmann\Money\Money;
use InvalidArgumentException;

/**
 * Tax option class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Tax extends ParentTax
{
    /**
     * {@inheritdocs}
     */
    protected $struct = [
        'id' => [
            'type' => ['integer', 'string'],
        ],
        'name' => [
            'required',
            'type' => 'string',
        ],
        'value' => [
            'type' => ['SebastianBergmann\\Money\\Money', 'numeric'],
        ],
    ];

    /**
     * {@inheritdocs}
     */
    public function getValue($price)
    {
        if ($price instanceof Money === false) {
            throw new InvalidArgumentException('The given value is not a valid Money object.');
        }

        if ($this->value instanceof Money) {
            return $this->value;
        }

        return $price->multiply($this->value / 100);
    }
}
