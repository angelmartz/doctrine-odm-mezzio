<?php
declare(strict_types=1);

namespace AngelMartz\DoctrineODMMezzio\Service;

use Interop\Container\ContainerInterface;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;

class ConnectionFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) 
    {
        $connectionString = isset($this->config['connection_string'])
            ? $this->config['connection_string'] : null;
        $dbName = null;

        if (empty($connectionString)) {
            $connectionString = 'mongodb://';
            $user = $this->config['user'];
            $password = $this->config['password'];
            $dbName = $this->config['dbname'];

            if ($user && $password) {
                $connectionString .= $user . ':' . $password . '@';
            }

            $connectionString .= $this->config['server'] . ':' . $this->config['port'];
            
            if ($dbName) {
                $connectionString .= '/' . $dbName;
            }

        } else {
            // parse dbName from the connectionString
            $dbStart = strpos($connectionString, '/', 11);

            if (false !== $dbStart) {
                $dbEnd = strpos($connectionString, '?');

                $dbName = substr(
                    $connectionString,
                    $dbStart + 1,
                    $dbEnd ? ($dbEnd - $dbStart - 1) : PHP_INT_MAX
                );
            }
        }

        $configuration = null;
        if ($container->has($this->getServiceName('configuration'))) {
            /** @var $configuration \Doctrine\ODM\MongoDB\Configuration */
            $configuration = $container->get($this->getServiceName('configuration'));
            // Set defaultDB to $dbName, if it's not defined in configuration
            if (null === $configuration->getDefaultDB()) {
                $configuration->setDefaultDB($dbName);
            }
        }

        return Connection($connectionString, $$this->config['options'], $configuration);
    }


    protected function getDefaultConfig(): array
    {
        return [];
    }
}