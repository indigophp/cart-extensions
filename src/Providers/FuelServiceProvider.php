<?php

/*
 * This file is part of the Indigo Cart Extensions package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Providers;

use Indigo\Cart\Store;
use Fuel\Dependency\ServiceProvider;

/**
 * Provides cart services
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public $provides = [
        'cart',
        'store',
        'store.session',
        'store.native_session',
    ];

    /**
     * {@inheritdoc}
     */
    public function provide()
    {
        $this->register('cart', function($context, $config = [])
        {
            if ($context->isMultiton())
            {
                $id = $context->getName() ?: 'default';
            }
            else
            {
                $id = 'default';
            }

            if ( ! is_array($config))
            {
                $config = ['store' => $config];
            }

            $app = $this->getApp();
            $config = $app->getConfig();

            $config->load('cart', true);

            $config = array_merge($config->get('cart.'.$id, [
                    'store'     => 'store.session',
                    'auto_save' => true,
                ]),
                $config
            );

            $cart = $dic->resolve('Indigo\\Cart\\SimpleCart', [$id]);

            $config['store'] = result($config['store']);

            if ($config['store'] instanceof Store)
            {
                $store = $config['store'];
            }
            else
            {
                $store = $dic->resolve($config['store']);
            }

            $store->load($cart);

            if ($config['auto_save'])
            {
                $event = $app->getEvent();

                $event->on('shutdown', function() use($cart, $store) {
                    $store->save($cart);
                });
            }

            return $cart;
        });

        $this->register('store.session', function ($context, $sessionKey = 'cart')
        {
            try
            {
                $app = $this->getApp();

                $session = $app->getSession();
            }
            catch (\Fuel\Dependency\ResolveException $e)
            {
                $session = null;
            }

            if ( ! $session)
            {
                $session = $context->resolve('session');
            }

            return $context->resolve('Indigo\Cart\Store\FuelSession', [$session, $sessionKey]);
        });

        $this->register('store.native_session', 'Indigo\Cart\Store\Session');
    }

    /**
     * Returns the current app
     *
     * @return \Fuel\Foundation\Application
     */
    private function getApp()
    {
        $stack = $this->container->resolve('requeststack');

        if ($request = $stack->top())
        {
            $app = $request->getComponent()->getApplication();
        }
        else
        {
            $app = $this->container->resolve('application::__main');
        }
    }
}
