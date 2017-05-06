<?php

namespace Venom;

use Symfony\Component\Console\Command\Command;
use Appstract\HostsFile\Processor as HostsFile;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command
{
    public function configure()
    {
        $this->setName('remove')
                ->setDescription('Remove hosts file entry')
                ->addArgument('domain', InputArgument::REQUIRED, 'Domain');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $host = new HostsFile();
        $host->removeLine($input->getArgument('domain'))->save();

        $output->writeln(sprintf('Removed: %s', $input->getArgument('domain')));
    }
}
