<?php
declare(strict_types=1);

namespace AngelMartz\DoctrineODMMezzio\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use Interop\Container\ContainerInterface;

class DocumentManagerFactory extends AbstractFactory {

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
		return DocumentManager::create(
			$container->get($this->getServiceName('connection')),
			$container->get($this->getServiceName('configuration'))
		);
	}


	protected function getDefaultConfig(): array {
		return [
			'connection'    => 'odm_default',
			'configuration' => 'odm_default',
		];
	}
}