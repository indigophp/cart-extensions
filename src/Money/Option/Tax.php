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

use Indigo;
use SebastianBergmann\Money\Money;
use InvalidArgumentException;

/**
 * Tax option class
 *
 * Calculate tax based on price
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Tax extends Indigo\Cart\Option\Tax implements OptionInterface
{
    /**
     * {@inheritdocs}
     */
    protected $struct = array(
        'id' => array(
            'type' => array('integer', 'string')
        ),
        'name' => array(
            'required',
            'type' => 'string',
        ),
        'value' => array(
            'type' => array('SebastianBergmann\\Money\\Money', 'numeric')
        ),
    );

    /**
     * {@inheritdocs}
     */
    public function getValue($price)
    {
        if ($price instanceof Money === false) {
            throw new InvalidArgumentException('$price should be an instance of SebastianBergmann\\Money\\Money');
        }

        if ($this->value instanceof Money) {
            return $this->value;
        }

        return $price->multiply($this->value / 100);
    }
}
