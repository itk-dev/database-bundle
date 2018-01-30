<?php

namespace ItkDev\DatabaseBundle\Command;

/**
 * Class DatabaseDumpCommand.
 */
class DatabaseDumpCommand extends AbstractDatabaseCommand
{
    protected function configure()
    {
        $this->setName('itk-dev:database:dump')
            ->setDescription('Dump database.');
    }

    protected function doStuff()
    {
        $connection = $this->getContainer()->get('doctrine.dbal.default_connection');
        if ('mysql' !== $connection->getDatabasePlatform()->getName()) {
            throw new \RuntimeException('Not a mysql database platform');
        }

        $cmd = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s',
            escapeshellarg($this->host),
            escapeshellarg($this->username),
            escapeshellarg($this->password),
            escapeshellarg($this->database)
        );

        $result = $this->runCommand($cmd);

        if ($result['exit_status'] > 0) {
            throw new \Exception('Could not dump database: '.var_export($result['output'], true));
        }

        echo implode(PHP_EOL, $result['output']), PHP_EOL;
    }
}
