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

        $pack = $this->getPackNamespace($command);

        if ($pack) {
            if (isset($app['singular.packs'][$pack])) {
                $app['console.command_locator']->locate($pack);
            }
        }
        
        return parent::doRun($input, $output);
    }

    /**
     * Recupera o namespace do pacote do comando.
     *
     * @param $command
     * @return null
     */
    protected function getPackNamespace($command)
    {
        $namespace = null;

        $parts = explode(':', $command);

        if (count($parts) > 1) {
            $namespace = $parts[0];
        }

        return $namespace;
    }
}