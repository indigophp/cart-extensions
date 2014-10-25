<?php

/*
 * This file is part of the Indigo Cart Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Stub;

use Fuel\Session\Manager;

/**
 * Session Manager stub
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class SessionManager extends Manager
{
    public function get() { }
    public function set() { }
    public function delete() { }
}
