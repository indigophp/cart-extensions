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

use Indigo\Cart\ItemInterface;
use Indigo\Container\Collection;
use Fuel\Validation\Rule\Type;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\CurrencyMismatchException;
use InvalidArgumentException;

/**
 * Money Cart class
 *
 * Uses Sebastian Bergmann's Money implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Cart extends \Indigo\Cart\Cart
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
    public function __construct($id = null, Currency $currency = null)
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
        if ($item instanceof Item === false) {
            throw new InvalidArgumentException('$item should be an instance of Indigo\\Cart\\Money\\Item');
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

            $total = $total->add($subtotal);
        }

        return $total;
    }
}
