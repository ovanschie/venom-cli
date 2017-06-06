<?php

namespace Venom;

use Appstract\LushHttp\Lush;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateCommand extends Command
{
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
        $app_version = '@package_version@';
        $releases = (new Lush('https://api.github.com/repos/ovanschie/venom-cli'))->get('tags')->getResult();
        $remote_version = $releases[0]->name;

        if (version_compare($app_version, $remote_version, '<')) {
            $output->writeln('Downloading update...');

            $process = new Process('curl https://raw.githubusercontent.com/ovanschie/venom-cli/master/install.sh -0 | sh');
            $process->run();

            if (! $process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            echo $process->getOutput();
        } else {
            $output->writeln('This is the latest version');
        }
    }
}
