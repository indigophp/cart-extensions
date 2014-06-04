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

use Indigo\Container\Struct;
use SebastianBergmann\Money\Money;
use Serializable;

/**
 * Money Cart Item Option class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Option extends Struct implements OptionInterface, Serializable
{
    use \Indigo\Container\Helper\Id;
    use \Indigo\Container\Helper\Serializable;

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
    public function getValue(Money $price)
    {
        return $this->value;
    }
}
