<?php

namespace ItkDev\DatabaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDatabaseCommand extends ContainerAwareCommand
{
    /** @var OutputInterface */
    protected $output;

    /** @var InputInterface */
    protected $input;

    /** @var \Doctrine\DBAL\Driver\Connection */
    protected $connection;

    /** @var string */
    protected $host;

    /** @var string */
    protected $database;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    abstract protected function doStuff();

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null|int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $parameters = $this->getContainer()->getParameterBag();
        $this->host = $parameters->get('database_host');
        $this->database = $parameters->get('database_name');
        $this->username = $parameters->get('database_user');
        $this->password = $parameters->get('database_password');

        $this->doStuff();
    }

    /**
     * Runs a system command and returns the output.
     *
     * @param $command
     * @param $streamOutput
     * @param $outputInterface mixed
     *
     * @return array
     */
    protected function runCommand($command)
    {
        $command .= ' >&1';
        exec($command, $output, $exit_status);

        return [
          'output' => $output,
          'exit_status' => $exit_status,
        ];
    }
}
