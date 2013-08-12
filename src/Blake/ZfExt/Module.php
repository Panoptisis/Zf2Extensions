<?php

namespace Blake\ZfExt;

/**
 * @author Blake Harley <blake@blakeharley.com>
 * @since  0.1
 */
class Module
{
	/**
	 * Gets the configuration array.
	 *
	 * @return array
	 */
	public function getConfig()
	{
		return include __DIR__ . '/../../../config/module.config.php';
	}

	/**
	 * Autoloaded by composer, so this is empty.
	 *
	 * @return array
	 */
	public function getAutoloaderConfig()
	{
	}
}