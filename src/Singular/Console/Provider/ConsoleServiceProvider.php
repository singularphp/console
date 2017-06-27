<?php

namespace Singular\Console\Provider;

use Pimple\Container;
use Knp\Provider\ConsoleServiceProvider as BaseProvider;
use Singular\Console\Command\CommandLocator;
use Singular\Console\Console\Application;

class ConsoleServiceProvider extends BaseProvider
{
    public function register(Container $app)
    {
        $console = parent::register($app);

        $app['console.class'] = Application::class;
        $app['console.command_locator'] = function () use ($app){
            return new CommandLocator(
                $app['singular.packs'],
                $app['console']
            );
        };

        return $console;
    }
}