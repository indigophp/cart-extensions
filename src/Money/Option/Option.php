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

use Indigo\Cart\Option\Option as ParentOption;
use SebastianBergmann\Money\Money;
use InvalidArgumentException;

/**
 * Money Cart Item Option class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Option extends ParentOption
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
            'type' => 'SebastianBergmann\\Money\\Money'
        ),
    );

    public function getValue($price)
    {
        if ($price instanceof Money === false) {
            throw new InvalidArgumentException('The given value is not a valid Money object.');
        }

        return parent::getValue($price);
    }
}
