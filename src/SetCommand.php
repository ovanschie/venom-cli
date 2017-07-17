<?php

namespace Venom;

use Exception;
use Symfony\Component\Console\Command\Command;
use Appstract\HostsFile\Processor as HostsFile;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetCommand extends Command
{
    public function configure()
    {
        $this->setName('set')
                ->setDescription('Add/update hosts file entry')
                ->addArgument('ip', InputArgument::REQUIRED, 'IP address')
                ->addArgument('domain', InputArgument::REQUIRED, 'Domain')
                ->addArgument('aliases', InputArgument::IS_ARRAY, 'Aliases (space separated)');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (! filter_var($input->getArgument('ip'), FILTER_VALIDATE_IP)) {
            throw new Exception(sprintf("'%s', is not a valid ip", $input->getArgument('ip')));
        }

        if (! filter_var($input->getArgument('domain'), FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9\\.]*[a-zA-Z0-9]+?/']])) {
            throw new Exception(sprintf("'%s', is not a valid domain", $input->getArgument('domain')));
        }

        $aliases = [];

        if ($input->hasArgument('aliases')) {
            $aliases = $input->getArgument('aliases');
        }

        $host = new HostsFile();
        $host->set($input->getArgument('ip'), $input->getArgument('domain'), $aliases)->save();

        $output->writeln(sprintf('Set: %s - %s [%s]', $input->getArgument('ip'), $input->getArgument('domain'), implode(', ', $aliases)));
    }
}
