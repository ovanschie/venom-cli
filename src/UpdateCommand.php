<?php

namespace Venom;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this->setName('update')
            ->setDescription('Update Venom-CLI to the latest version');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = new Process('curl https://raw.githubusercontent.com/ovanschie/venom-cli/master/install.sh -0 | sh');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
