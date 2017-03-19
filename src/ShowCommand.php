<?php

namespace Venom;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class ShowCommand extends Command
{

    /**
     *
     */
    public function configure()
    {
        $this->setName('show')
                ->setDescription('Show/List hosts file entries');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $host = new Hosts("/Users/olav/Desktop/testhosts");
        $lines = $host->getLines();

        $parsedEntries = array_map(function ($domain, $attributes) {
            return [trim($attributes['ip']), trim($domain), trim($attributes['aliases'])];
        }, array_keys($lines), $lines);

        $table = new Table($output);
        $table->setHeaders(['Ip', 'Domain', 'Aliases'])
                ->setRows($parsedEntries)
                ->render();

        $output->writeln(PHP_EOL . sprintf('Listed: %s lines', count($lines)));
    }

}