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
 * Money Cart Item Option class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Option extends Indigo\Cart\Option\Option implements OptionInterface
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

    /**
     * {@inheritdocs}
     */
    public function getValue($price)
    {
        if ($price instanceof Money === false) {
            throw new InvalidArgumentException('$price should be an instance of SebastianBergmann\\Money\\Money');
        }

        return parent::getValue($price);
    }
}
