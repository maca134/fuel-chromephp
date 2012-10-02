<?php
/**
 * Integrated ChromePHP into FuelPHP
 *
 * @package    Chromephp
 * @version    0.1
 * @author     Matthew McConnell
 */

namespace Chromephp;

class Log extends \Fuel\Core\Log
{
    /**
     * Logs a message with the Info Log Level
     *
     * @param  string $msg    The log message
     * @param  string $method The method that logged
     * @return bool   If it was successfully logged
     */
    public static function info($msg, $method = null)
    {
        Chromephp::info($msg . ' - ' . $method);
        return parent::info($msg, $method);
    }

    /**
     * Logs a message with the Debug Log Level
     *
     * @param  string $msg    The log message
     * @param  string $method The method that logged
     * @return bool   If it was successfully logged
     */
    public static function debug($msg, $method = null)
    {
        Chromephp::log($msg . ' - ' . $method);
        return parent::debug($msg, $method);
    }

    /**
     * Logs a message with the Warning Log Level
     *
     * @param  string $msg    The log message
     * @param  string $method The method that logged
     * @return bool   If it was successfully logged
     */
    public static function warning($msg, $method = null)
    {
        Chromephp::warn($msg . ' - ' . $method);
        return parent::warning($msg, $method);
    }

    /**
     * Logs a message with the Error Log Level
     *
     * @param  string $msg    The log message
     * @param  string $method The method that logged
     * @return bool   If it was successfully logged
     */
    public static function error($msg, $method = null)
    {
        Chromephp::error($msg . ' - ' . $method);
        return parent::error($msg, $method);
    }

}