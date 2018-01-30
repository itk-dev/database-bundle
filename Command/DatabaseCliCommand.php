<?php

namespace ItkDev\DatabaseBundle\Command;

/**
 * Class DatabaseCliCommand.
 */
class DatabaseCliCommand extends AbstractDatabaseCommand
{
    protected function configure()
    {
        $this->setName('itk-dev:database:cli')
            ->setDescription('Open database.');
    }

    protected function doStuff()
    {
        $connection = $this->getContainer()->get('doctrine.dbal.default_connection');
        if ('mysql' !== $connection->getDatabasePlatform()->getName()) {
            throw new \RuntimeException('Not a mysql database platform');
        }

        $cmd = sprintf(
            'mysql --host=%s --user=%s --password=%s %s',
            escapeshellarg($this->host),
            escapeshellarg($this->username),
            escapeshellarg($this->password),
            escapeshellarg($this->database)
        );

        $pipes = [];
        $process = proc_open($cmd, [0 => STDIN, 1 => STDOUT, 2 => STDERR], $pipes);
        $status = proc_get_status($process);
        $exitCode = proc_close($process);
        exit($status['running'] ? $exitCode : $status['exitcode']);
    }
}
