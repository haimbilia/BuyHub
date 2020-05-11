<?php

spl_autoload_register('includeApiTraits');

function includeApiTraits($className)
{
	$path = dirname(__FILE__) . '/api-traits/';
	include_once $path . $className . '.php';
}