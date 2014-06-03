<?php

/*
 * This file is part of the Indigo Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Money;

use Indigo\Cart;
use Indigo\Container\Collection;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\CurrencyMismatchException;

/**
 * Money Cart class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Cart extends Cart\Cart
{
    /**
     * Currency of cart
     *
     * @var Currency
     */
    protected $currency;

    public function __construct($id = null, Currency $currency = null)
    {
        $this->id = $id;

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
     * Set Currency
     *
     * @param  Currency $currency
     * @return Cart
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * {@inheritdocs}
     *
     * @throws CurrencyMismatchException
     */
    public function add(ItemInterface $item)
    {
        if ($item instanceof Item) {
            throw new InvalidArgumentException('');
        }

        $currency = $item['price']->getCurrency();

        if (isset($this->currency) === false) {
            $this->currency = $currency;
        } elseif ($this->currency != $currency) {
            throw new CurrencyMismatchException;
        }

        return parent::add($item);
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

            $total->add($subtotal);
        }

        return $total;
    }
}
