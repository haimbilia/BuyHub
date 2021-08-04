<?php

spl_autoload_register('includeApiTraits');

/**
 * includeApiTraits - Used to include called class.
 *
 * @param  string $className
 * @return void
 */
function includeApiTraits(string $className)
{
	$path = dirname(__FILE__) . '/Resources/';
	include_once $path . $className . '.php';
}