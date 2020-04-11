<?php

namespace ItkDev\DatabaseBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractDatabaseCommand extends Command
{
    /** @var ManagerRegistry  */
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct();
        $this->registry = $registry;
    }

    protected function configure()
    {
        $this->addOption('connection', null, InputOption::VALUE_REQUIRED, 'The connection name to use');
    }

    protected function getParams(InputInterface $input)
    {
        $name = $input->getOption('connection');
        $connection = $this->registry->getConnection($name);
        $params = $connection->getParams();
        if ($params['driver'] === 'pdo_mysql' && !isset($params['port'])) {
            $params['port'] = 3306;
        }

        return $params;
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

    /**
     * Executes a command.
     *
     * @param $command
     */
    protected function executeCommand($command)
    {
        $pipes = [];
        $process = proc_open($command, [0 => STDIN, 1 => STDOUT, 2 => STDERR], $pipes);
        $status = proc_get_status($process);
        $exitCode = proc_close($process);
        exit($status['running'] ? $exitCode : $status['exitcode']);
    }
}
