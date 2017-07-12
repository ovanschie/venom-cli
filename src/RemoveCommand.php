<?php

namespace Venom;

use Symfony\Component\Console\Command\Command;
use Appstract\HostsFile\Processor as HostsFile;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command
{
    protected $output;

    /**
     *
     */
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
        $this->output = $output;

        if ($input->getArgument('domain') == '*') {
            return $this->removeAll();
        }

        return $this->remove(explode(',', $input->getArgument('domain')));
    }

    /**
     * @param $domains
     */
    protected function remove($domains)
    {
        $host = new HostsFile();

        foreach ($domains as $domain) {
            $host->removeLine($domain);
        }

        $host->save();

        $this->output->writeln(sprintf('Removed: %s', implode(' ', $domains)));
    }

    /**
     *
     */
    protected function removeAll()
    {
        $host = new HostsFile();

        foreach ($host->getLines() as $line) {
            if ($line['domain'] != 'localhost' && $line['domain'] != 'broadcasthost') {
                $host->removeLine($line['domain']);
            }
        }

        $host->save();

        $this->output->writeln('Removed all entries');
    }
}
