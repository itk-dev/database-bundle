<?php

namespace ItkDev\DatabaseBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatabaseDumpCommand.
 */
class DatabaseDumpCommand extends AbstractDatabaseCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('itk-dev:database:dump')
            ->setDescription('Dump database.');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = $this->getParams($input);
        $driver = $params['driver'];

        switch ($driver) {
            case 'pdo_mysql':
                $cmd = sprintf(
                    'mysqldump --host=%s --port=%s --user=%s --password=%s %s',
                    escapeshellarg($params['host']),
                    escapeshellarg($params['port']),
                    escapeshellarg($params['user']),
                    escapeshellarg($params['password']),
                    escapeshellarg($params['dbname'])
                );
                break;
            case 'pdo_sqlite':
                $cmd = sprintf(
                    'sqlite3 %s .dump',
                    escapeshellarg($params['path'])
                );
                break;
            default:
                throw new \RuntimeException('Unknown driver: ' . $driver);
        }

        $result = $this->runCommand($cmd);

        if ($result['exit_status'] > 0) {
            throw new \Exception('Could not dump database: '.var_export($result['output'], true));
        }

        echo implode(PHP_EOL, $result['output']), PHP_EOL;

        return 0;
    }
}
