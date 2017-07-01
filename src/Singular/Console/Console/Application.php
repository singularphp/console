<?php

namespace Singular\Console\Console;

use Knp\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        $command = $this->getCommandName($input);

        $packs = $app['singular.packs']->keys();

        foreach ($packs as $pack) {
            $app['console.command_locator']->locate($pack);
        }
        
        return parent::doRun($input, $output);
    }
}