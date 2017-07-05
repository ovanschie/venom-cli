<?php

namespace Venom;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Appstract\HostsFile\Processor as HostsFile;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command
{
    public function configure()
    {
        $this->setName('show')
                ->setDescription('Show/List hosts file entries')
                ->addOption('plain', null, InputOption::VALUE_NONE, 'Display without table');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $host = new HostsFile();
        $lines = $host->getLines();

        if ($input->getOption('plain')) {
            foreach ($lines as $key => $line) {
                $output->writeLn($line['ip'].' '.$line['domain'].' '.$line['aliases']);
            }
        } else {
            $table = new Table($output);
            $table->setHeaders(['Ip', 'Domain', 'Aliases'])
                ->setRows($lines)
                ->render();

            $output->writeln(PHP_EOL.sprintf('Listed: %s lines', count($lines)));
        }
    }
}
