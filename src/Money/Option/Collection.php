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
use Indigo\Container\Collection as CollectionContainer;
use Indigo\Cart\Option\OptionInterface as OriginalOptionInterface;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;
use InvalidArgumentException;

/**
 * Option collection class
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Collection extends Indigo\Cart\Option\Collection implements OptionInterface
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(array $data = array(), $readOnly = false)
    {
        CollectionContainer::__construct(new Type('Indigo\\Cart\\Money\\Option\\OptionInterface'), array(), $readOnly);

        foreach ($data as $value) {
            $this->add($value);
        }
    }

    /**
     * {@inheritdocs}
     */
    public function add(OriginalOptionInterface $option, $pos = null)
    {
        if ($option instanceof OptionInterface === false) {
            throw new InvalidArgumentException('$option should be an instance of Indigo\\Cart\\Money\\Option\\OptionInterface');
        }

        return parent::add($option, $pos);
    }

    /**
     * {@inheritdocs}
     */
    public function getValue($price)
    {
        if ($price instanceof Money === false) {
            throw new InvalidArgumentException('$price should be an instance of SebastianBergmann\\Money\\Money');
        }

        $total = new Money(0, $price->getCurrency());

        foreach ($this->data as $option) {
            $value = $option->getValue($price);

            $total = $total->add($value);
            $price = $price->add($value);
        }

        return $total;
    }

    /**
     * Get value of type
     *
     * @param  boolean $filter If false, the given types will be filtered out
     * @return float
     */
    public function getValueOfType($price, Type $type, $filter = true)
    {
        if ($price instanceof Money === false) {
            throw new InvalidArgumentException('$price should be an instance of SebastianBergmann\\Money\\Money');
        }

        $total = new Money(0, $price->getCurrency());

        foreach ($this->data as $option) {
            $value = $option->getValue($price);

            $price = $price->add($value);

            if ($type->validate($option) === (bool) $filter) {
                $total = $total->add($value);
            }
        }

        return $total;
    }
}
