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

use Indigo\Cart\Option\Collection as ParentCollection;
use Indigo\Container\Collection as CollectionContainer;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;

/**
 * Money Collection
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Collection extends ParentCollection
{
    /**
     * {@inheritdoc}
     */
    public function getValue($price)
    {
        if ($price instanceof Money === false) {
            throw new \InvalidArgumentException('The given value is not a valid Money object.');
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
     * Returns the value of type
     *
     * @param boolean $filter If false, the given types will be filtered out
     *
     * @return Money
     */
    public function getValueOfType($price, Type $type, $filter = true)
    {
        if ($price instanceof Money === false) {
            throw new \InvalidArgumentException('The given value is not a valid Money object.');
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
