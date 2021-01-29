<?php

declare(strict_types=1);

namespace AngelMartz\DoctrineODMMezzio;

use AngelMartz\DoctrineODMMezzio\Service;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine' => $this->getDoctrineConfig(),
            'doctrine_factories' => $this->getDoctrineFactoryConfig()
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'abstract_factories' => [
                Service\ServiceAbstractFactory::class,
            ],
        ];
    }

    public function getDoctrineConfig() : array
    {
        return [];
    }

    public function getDoctrineFactoryConfig(): array
    {
        return [
            'documentmanager' => Service\DocumentManagerFactory::class,
            'configuration'  => Service\ConfigurationFactory::class,
        ];
    }
    
}
