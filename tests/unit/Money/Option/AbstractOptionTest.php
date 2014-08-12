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

use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;
use Codeception\TestCase\Test;

/**
 * Tests for Options
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class AbstractOptionTest extends Test
{
    /**
     * @var OptionInterface
     */
    protected $option;

    /**
     * @covers ::getValue
     */
    public function testValue()
    {
        $this->assertEquals(200, $this->option->getValue(new Money(100, new Currency('EUR')))->getAmount());
    }

    /**
     * @covers            ::getValue
     * @expectedException InvalidArgumentException
     */
    public function testValueFailure()
    {
        $this->option->getValue(null);
    }
}
