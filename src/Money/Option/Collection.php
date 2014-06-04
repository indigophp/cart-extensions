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

use Indigo\Container\Collection as CollectionContainer;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;
use Serializable;

/**
 * Option collection class
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Collection extends CollectionContainer implements OptionInterface, Serializable
{
    use \Indigo\Container\Helper\Id;
    use \Indigo\Container\Helper\Insert;
    use \Indigo\Container\Helper\Serializable;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(array $data = array(), $readOnly = false)
    {
        parent::__construct(new Type('Indigo\\Cart\\Money\\Option\\OptionInterface'), array(), $readOnly);

        foreach ($data as $value) {
            $this->add($value);
        }
    }

    /**
     * Add option to collection
     *
     * @param  OptionInterface $option
     * @param  int|null        $pos    Position to insert at
     * @return Collection
     */
    public function add(OptionInterface $option, $pos = null)
    {
        $id = $option->getId();

        if ($this->has($id) === false) {
            // Set parent, but disable the usage
            // Set option to read-only
            $option
                ->setParent($this)
                ->disableParent()
                ->setReadOnly();

            $this->insertAssoc($id, $option, $pos);
        }

        return $this;
    }

    /**
     * {@inheritdocs}
     */
    public function getValue(Money $price)
    {
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
    public function getValueOfType(Money $price, Type $type, $filter = true)
    {
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
