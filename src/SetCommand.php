<?php

namespace Venom;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetCommand extends Command
{

    public function configure()
    {
        $this->setName('set')
                ->setDescription('Add an entry to the hosts file')
                ->addArgument('ip', InputArgument::REQUIRED, 'IP-adres')
                ->addArgument('domain', InputArgument::REQUIRED, 'Domain')
                ->addArgument('aliases', InputArgument::OPTIONAL, 'Aliases');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $aliases = '';

        if ($input->hasArgument('aliases')) {
            $aliases = $input->getArgument('aliases');
        }

        $host = new Hosts("/Users/olav/Desktop/testhosts");
        $host->addLine($input->getArgument('ip'), $input->getArgument('domain'), $aliases)->save();

        $output->writeln(sprintf('Added: %s %s %s', $input->getArgument('ip'), $input->getArgument('domain'), $aliases));
    }

}