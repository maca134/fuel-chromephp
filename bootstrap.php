<?php
/**
 * Integrated ChromePHP into FuelPHP
 *
 * @package    Chromephp
 * @version    0.1
 * @author     Matthew McConnell
 */

Autoloader::add_core_namespace('Chromephp');

Autoloader::add_classes(array(
	'Chromephp\\Log' => __DIR__.'/classes/log.php',
	'Chromephp\\Error' => __DIR__.'/classes/error.php',
	'Chromephp\\Chromephp' => __DIR__.'/classes/chromephp.php',
	'Chromephp\\ChromephpData' => __DIR__.'/classes/chromephpdata.php',
));