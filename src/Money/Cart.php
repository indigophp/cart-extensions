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

use Indigo\Cart\Cart as ParentCart;
use Indigo\Container\Collection;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;

/**
 * Money Cart class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Cart extends ParentCart
{
    /**
     * Currency of cart
     *
     * Currency should be consistent in the same cart
     *
     * @var Currency
     */
    protected $currency;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Currency $currency, $id = null)
    {
        $this->id = $id;
        $this->currency = $currency;

        Collection::__construct(new Type('Indigo\\Cart\\Money\\Item'));
    }

    /**
     * Get Currency
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdocs}
     *
     * @return Money
     */
    public function getTotal($options = false)
    {
        $total = new Money(0, $this->currency);

        foreach ($this->data as $id => $item) {
            $subtotal = $item->getSubtotal($options);

            $total = $total->add($subtotal);
        }

        return $total;
    }
}
