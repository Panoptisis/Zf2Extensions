<?php

namespace Blake\ZfExt\Controller\Plugin;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Provides a quick way to get at the entity manager or entity repositories from
 * controllers.
 *
 * @author Blake Harley <blake@blakeharley.com>
 * @since  0.1
 */
class Entity extends AbstractPlugin
{
	/**
	 * Gets the entity manager or an entity repository.
	 *
	 * @param  string                         $entity The entity repository to get (optional)
	 * @return EntityManager|EntityRepository
	 */
	public function __invoke($entity = null)
	{
		// Return right away if we don't want a repository
		if (!$entity)
		{
			return $this->getEntityManager();
		}

		// See if we were given an entity without a namespace
		if (strpos($entity, ':') === false)
		{
			$entity = $this->getControllerNamespace() . ':' . $entity;
		}

		return $this->getEntityManager()->getRepository($entity);
	}

	/**
	 * Grabs the entity manager provided by DoctrineORMModule.
	 *
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		// XXX: Do we want to catch any DI exceptions here?
		return $this->getController()->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}

	/**
	 * Gets the namespace of the calling controller.
	 *
	 * @return string
	 */
	protected function getControllerNamespace()
	{
		return explode('\\', get_class($this->getController()))[0];
	}
} 