<?php
declare(strict_types=1);

namespace AngelMartz\DoctrineODMMezzio\Service;

use Doctrine\ODM\MongoDB\Configuration;
use Psr\Container\ContainerInterface;

class ConfigurationFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) 
    {
        $configuration = new Configuration();
    }

    protected function getDefaultConfig(): array
    {
        return [];
    }
}