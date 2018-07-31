<?php

namespace Singular\Console\Command;

use Symfony\Component\Finder\Finder;

class CommandLocator
{
    protected $packs = [];
    protected $console;

    public function __construct($packs, $console)
    {
        $this->packs = $packs;
        $this->console = $console;
    }

    /**
     * Localiza a registra os comandos de um pacote automaticamente.
     *
     * @param string $pack
     */
    public function locate($pack)
    {
        $finder = new Finder();
        $packDirectory = $this->packs[$pack]->getDirectory();
        $commandDir = $packDirectory.DIRECTORY_SEPARATOR."Command";

        if (is_dir($commandDir)) {
            foreach ($finder->name("*.php")->in($packDirectory.DIRECTORY_SEPARATOR."Command") as $file) {
                $commandClass = str_replace('.php','' , $file->getFilename());
                $fullClassName = "\\".$this->packs[$pack]->getNameSpace()."\\Command\\".$commandClass;

                if (class_exists($fullClassName)) {
                    $command = new $fullClassName;

                    if ($command instanceof \Singular\Console\Command\Command) {
                        $this->console->add($command);
                    }
                }
            }
        }
    }
}