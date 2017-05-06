<?php

namespace Venom;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SudoerCommand extends Command
{
    protected $file = '/etc/sudoers.d/venom';

    protected function configure()
    {
        $this->setName('sudoer')
            ->setDescription('Add sudoers file for Venom')
            ->addOption('add', null, InputOption::VALUE_NONE, 'This will add the sudoers file')
            ->addOption('remove', null, InputOption::VALUE_NONE, 'This will remove the sudoers file');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('add')) {
            $output->writeln($this->writeFile());
        } elseif ($input->getOption('remove')) {
            $output->writeln($this->removeFile());
        } else {
            $output->writeln('No option given');
        }
    }

    /**
     * add sudoers file.
     */
    protected function writeFile()
    {
        $fs = new Filesystem();

        if (file_exists($this->file)) {
            return 'Entry already exists';
        } else {
            $fs->dumpFile($this->file, 'Cmnd_Alias VENOM = /usr/local/bin/venom *
%admin ALL=(root) NOPASSWD: VENOM'.PHP_EOL);

            return 'Venom added to sudoers!';
        }
    }

    /**
     * remove sudoers file.
     */
    protected function removeFile()
    {
        $fs = new Filesystem();

        if (! file_exists($this->file)) {
            return 'Entry does not exists';
        } else {
            $fs->remove($this->file);

            return 'Venom removed from sudoers';
        }
    }
}
