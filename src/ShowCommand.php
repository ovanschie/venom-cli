<?php

namespace Venom;

use Exception;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Appstract\HostsFile\Processor as HostsFile;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command
{
    /**
     * @var
     */
    protected $output;

    /**
     *
     */
    public function configure()
    {
        $this->setName('show')
                ->setDescription('Show/List hosts file entries')
                ->addOption('output', null, InputOption::VALUE_REQUIRED, 'Output as plain text or JSON');
    }


    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $host = new HostsFile();
        $lines = $host->getLines();
        $format = $input->getOption('output') ? $input->getOption('output') : 'table';

        if (!in_array($format, ['plain', 'json', 'table'])) {
            throw new Exception(sprintf('%s is not a valid option, use plain, json or table', $format));
        }

        $func = "format{$format}";

        // call the format function
        $this->$func($lines);
    }

    /**
     * @param $lines
     */
    protected function formatPlain($lines)
    {
        foreach ($lines as $key => $line) {
            $this->output->writeLn($line['ip'].' '.$line['domain'].' '.$line['aliases']);
        }
    }

    /**
     * @param $lines
     */
    protected function formatJson($lines)
    {
        $this->output->writeLn(json_encode($lines));
    }

    /**
     * @param $lines
     */
    protected function formatTable($lines)
    {
        $table = new Table($this->output);
        $table->setHeaders(['Ip', 'Domain', 'Aliases'])
            ->setRows($lines)
            ->render();

        $this->output->writeln(PHP_EOL.sprintf('Listed: %s lines', count($lines)));
    }
}
