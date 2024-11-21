<?php

namespace computerShop;

/**
 * Error and Exception Handler
 * Handles all errors and exceptions in the application
 */
class ErrorHandler
{
    // Error levels for logging
    private const ERROR_LEVELS = [
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSE',
        E_NOTICE => 'NOTICE',
        E_CORE_ERROR => 'CORE ERROR',
        E_CORE_WARNING => 'CORE WARNING',
        E_COMPILE_ERROR => 'COMPILE ERROR',
        E_COMPILE_WARNING => 'COMPILE WARNING',
        E_USER_ERROR => 'USER ERROR',
        E_USER_WARNING => 'USER WARNING',
        E_USER_NOTICE => 'USER NOTICE',
        E_STRICT => 'STRICT',
        E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
        E_DEPRECATED => 'DEPRECATED',
        E_USER_DEPRECATED => 'USER DEPRECATED',
    ];

    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function exceptionHandler(\Throwable $e)
    {
        $this->logError(
            'EXCEPTION',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );
        $this->displayError(
            'Exception',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getCode()
        );
    }

    /**
     * Handles PHP errors
     * @param int $errno Error number
     * @param string $errstr Error message
     * @param string $errfile File where error occurred
     * @param int $errline Line number
     * @return bool
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $errorLevel = self::ERROR_LEVELS[$errno] ?? 'UNKNOWN';
        $this->logError($errorLevel, $errstr, $errfile, $errline);

        if (DEBUG) {
            $this->displayError($errorLevel, $errstr, $errfile, $errline);
        }

        return true;
    }

    /**
     * Handles fatal PHP errors
     */
    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $this->logError(
                'FATAL ERROR',
                $error['message'],
                $error['file'],
                $error['line']
            );

            if (DEBUG) {
                $this->displayError(
                    'Fatal Error',
                    $error['message'],
                    $error['file'],
                    $error['line']
                );
            } else {
                $this->displayError('Server Error', 'An internal server error occurred.', '', '', 500);
            }
        }
    }

    /**
     * Logs error information to file
     * @param string $level Error level
     * @param string $message Error message
     * @param string $file File where error occurred
     * @param int $line Line number
     * @param string $trace Stack trace
     */
    protected function logError($level, $message, $file, $line, $trace = '')
    {
        $log = sprintf(
            "[%s] %s\nMessage: %s\nFile: %s\nLine: %d\n",
            date('Y-m-d H:i:s'),
            $level,
            $message,
            $file,
            $line
        );

        if ($trace) {
            $log .= "Trace:\n" . $trace . "\n";
        }

        $log .= "--------------------\n";

        error_log($log, 3, ROOT . '/tmp/errors.log');

        if (DEBUG) {
            $debugLog = sprintf(
                "[%s] Request URL: %s\nRequest Method: %s\nUser IP: %s\n",
                date('Y-m-d H:i:s'),
                $_SERVER['REQUEST_URI'] ?? 'N/A',
                $_SERVER['REQUEST_METHOD'] ?? 'N/A',
                $_SERVER['REMOTE_ADDR'] ?? 'N/A'
            );
            error_log($debugLog, 3, ROOT . '/tmp/debug.log');
        }
    }

    /**
     * Displays error information based on environment
     * @param string $type Error type
     * @param string $message Error message
     * @param string $file File name
     * @param string $line Line number
     * @param int $code HTTP response code
     */
    protected function displayError($type, $message, $file = '', $line = '', $code = 404)
    {
        http_response_code($code);

        if ($code == 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die();
        }

        if (DEBUG) {
            $error = [
                'type' => $type,
                'message' => $message,
                'file' => $file,
                'line' => $line,
                'code' => $code,
                'server' => $_SERVER,
                'request' => $_REQUEST,
                'session' => $_SESSION ?? [],
                'cookies' => $_COOKIE
            ];

            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode($error);
            } else {
                require WWW . '/errors/development.php';
            }
        } else {
            require WWW . '/errors/production.php';
        }

        die();
    }

    protected function isAjaxRequest(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
