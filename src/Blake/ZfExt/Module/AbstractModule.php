<?php

namespace Blake\ZfExt\Module;

use Doctrine\ORM\Mapping\UnderscoreNamingStrategy as NamingStrategy;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

/**
 * Provides common settings for a module that uses Doctrine's ORM.
 * 
 * @author Blake Harley <blake@blakeharley.com>
 * @since  0.1
 */
abstract class AbstractModule
{
	/**
	 * The reflection information for this class.
	 * 
	 * @var ReflectionClass
	 */
	protected $reflection = null;

	/**
	 * Gets the configuration array.
	 * 
	 * @return array
	 */
	public function getConfig()
	{
		$ref = $this->getReflection();
		$namespace = $ref->getNamespaceName();
		$dir = dirname($ref->getFileName());

		// Things that shouldn't need to be changed often
		$defaults = [
			// Load routes from YAMK
			'router' => Yaml::parse($dir . '/config/router.config.yaml'),

			// Doctrine settings
			'doctrine' => [
				'driver' => [
					$namespace . '_annotation_driver' => [
						'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
						'cache' => 'array',
						'paths' => [
							$dir . '/src/' . $namespace . '/Entity',
						],
					],

					'orm_default' => [
						'drivers' => [
							 $namespace . '\Entity' => $namespace . '_annotation_driver',
						],
					],
				],

				'configuration' => [
					'orm_default' => [
						'naming_strategy' => new NamingStrategy,
						'entity_namespaces' => [
							$namespace =>  $namespace . '\Entity',
						],
					],
				],
			],

			// View setup
			'view_manager' => [
				'display_not_found_reason' => APPLICATION_ENV == 'development',
				'display_exceptions'       => APPLICATION_ENV == 'development',
				'doctype'                  => 'HTML5',
				'not_found_template'       => 'error/404',
				'exception_template'       => 'error/index',
				'template_map' => [
					'layout/layout'           => $dir . '/view/layout/layout.phtml',
					// 'error/404'               => $dir . '/view/error/404.phtml',
					// 'error/index'             => $dir . '/view/error/index.phtml',
				],
				'template_path_stack' => [
					$dir . '/view',
				],
			],
		];

		$config = include $dir . '/config/module.config.php';

		return array_replace_recursive($defaults, $config);
	}

	/**
	 * Returns the autoloader configuration.
	 * 
	 * @return array
	 */
	public function getAutoloaderConfig()
	{
		$ref = $this->getReflection();
		$namespace = $ref->getNamespaceName();
		$dir = dirname($ref->getFileName());

		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					$namespace => $dir . '/src/' . $namespace,
				],
			],
		];
	}

	/**
	 * Lazy-loads the reflection information for the implementing module.
	 * 
	 * @return ReflectionClass
	 */
	protected function getReflection()
	{
		if (!$this->reflection)
		{
			$this->reflection = new ReflectionClass($this);
		}

		return $this->reflection;
	}
}