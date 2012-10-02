<?php
/**
 * Integrated ChromePHP into FuelPHP
 *
 * @package    Chromephp
 * @version    0.1
 * @author     Matthew McConnell
 */

namespace Chromephp;

/**
 * Exception for PHP errors.
 */
class Chromephp_Exception extends \FuelException {

    public function __construct($errstr, $errno, $errfile, $errline) {
        parent::__construct($errstr, $errno);
    }

}

/**
 * Exception for PHP error levels.
 */
class Chromephp_Exception_Error extends Chromephp_Exception {
    
}

class Chromephp_Exception_Warning extends Chromephp_Exception {
    
}

class Chromephp_Exception_Strict extends Chromephp_Exception {
    
}

class Chromephp_Exception_Parse extends Chromephp_Exception {
    
}

class Chromephp_Exception_Notice extends Chromephp_Exception {
    
}

class Error extends \Fuel\Core\Error {

    /**
     * Exception handler
     *
     * @param  Exception $e the exception
     * @return bool
     */
    public static function exception_handler(\Exception $e) {
        self::handle_exception($e);
        $return = parent::exception_handler($e);
        if ($return !== null) {
            return $return;
        }
    }

    /**
     * Error handler
     *
     * @param  int    $severity the severity code
     * @param  string $message  the error message
     * @param  string $filepath the path to the file throwing the error
     * @param  int    $line     the line number of the error
     * @return bool   whether to continue with execution
     */
    public static function error_handler($severity, $message, $filepath, $line) {
        switch ($severity) {
            case E_NOTICE:
            case E_USER_NOTICE:
                $e = new Chromephp_Exception_Notice($message, $severity, $filepath, $line);
                break;

            case E_WARNING:
            case E_USER_WARNING:
                $e = new Chromephp_Exception_Warning($message, $severity, $filepath, $line);
                break;

            case E_STRICT:
                $e = new Chromephp_Exception_Strict($message, $severity, $filepath, $line);
                break;

            case E_PARSE:
                $e = new Chromephp_Exception_Parse($message, $severity, $filepath, $line);
                break;

            default:
                $e = new Chromephp_Exception_Error($message, $severity, $filepath, $line);
        }
        self::handle_exception($e);

        return parent::error_handler($severity, $message, $filepath, $line);
    }

    /**
     * PHP shutdown handler
     *
     * @return void
     */
    public static function shutdown_handler() {
        $last_error = error_get_last();

        // Only show valid fatal errors
        if ($last_error AND in_array($last_error['type'], static::$fatal_levels)) {
            $severity = static::$levels[$last_error['type']];
            logger(\Fuel::L_ERROR, $severity . ' - ' . $last_error['message'] . ' in ' . $last_error['file'] . ' on line ' . $last_error['line']);

            $error = new Chromephp_Exception_Exception($last_error['message'], $last_error['type'], 0, $last_error['file'], $last_error['line']);
            static::exception_handler($error);
            if (\Fuel::$env != \Fuel::PRODUCTION) {
                static::show_php_error($error);
            } else {
                static::show_production_error($error);
            }

            exit(1);
        }
    }

    /**
     * Exception handler
     *
     * @param  Exception $e the exception
     * @return bool
     */
    private static function handle_exception($exception) {
        $data = new ChromephpData($exception);
        Chromephp::error($data->data);
    }

}