<?php

namespace ItkDev\DatabaseBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DatabaseCliCommand.
 */
class DatabaseCliCommand extends AbstractDatabaseCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('itk-dev:database:cli')
            ->setDescription('Open database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = $this->getParams($input);
        $driver = $params['driver'];

        switch ($driver) {
            case 'pdo_mysql':
                $cmd = sprintf(
                    'mysql --host=%s --port=%s --user=%s --password=%s %s',
                    escapeshellarg($params['host']),
                    escapeshellarg($params['port']),
                    escapeshellarg($params['user']),
                    escapeshellarg($params['password']),
                    escapeshellarg($params['dbname'])
                );
                break;
            case 'pdo_sqlite':
                $cmd = sprintf(
                    'sqlite3 %s',
                    escapeshellarg($params['path'])
                );
                break;
            default:
                throw new \RuntimeException('Unknown driver: ' . $driver);
        }

        $this->executeCommand($cmd);

        return 0;
    }
}
