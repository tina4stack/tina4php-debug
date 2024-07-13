<?php

/**
 * Tina4 - This is not a 4ramework.
 * Copy-right 2007 - current Tina4
 * License: MIT https://opensource.org/licenses/MIT
 */

namespace Tina4;

use Psr\Log\LogLevel;
use Cesargb\Log\Rotation;
use Cesargb\Log\Exceptions\RotationFailed;

/**
 * Debug class to make messages in the console
 * @property Debug logger
 * @package Tina4
 */
class Debug implements \Psr\Log\LoggerInterface
{
    public static array $errors = [];
    public static array $logLevel = [];
    public static array $context = [];

    public static $logger;

    public string $colorRed = "\e[31;1m";
    public string $colorOrange = "\e[33;1m";
    public string $colorGreen = "\e[32;1m";
    public string $colorCyan = "\e[36;1m";
    public string $colorYellow = "\e[0;33m";
    public string $colorReset = "\e[0m";

    public string $documentRoot = "./";

    /**
     * @var string Redirects logs to another file
     */
    public static string $alternativeFile = "debug.log";

    /**
     * Creates a debug message based on the debug level
     * @param string $message
     * @param string $level TINA4_LOG_ALL, TINA4_LOG_DEBUG, TINA4_LOG_INFO, TINA4_LOG_WARNING, TINA4_LOG_ERROR
     * @param string $alternativeFile
     */
    public static function message(string $message, string $level = LogLevel::INFO, string $alternativeFile="debug.log") : void
    {
        if (self::$logger === null) {
            self::$logger = new self();
        }
        self::$alternativeFile = $alternativeFile;
        self::$logger->log($level, $message, self::$context);
    }

    /**
     * Gets a cool color for the output
     * @param string $level
     * @return string
     */
    private function getColor(string $level): string
    {
        $color = $this->colorCyan;
        switch ($level) {
            case LogLevel::ALERT:
                $color = $this->colorYellow;
                break;
            case LogLevel::NOTICE:
                $color = $this->colorGreen;
                break;
            case LogLevel::WARNING:
                $color = $this->colorOrange;
                break;
            case LogLevel::ERROR:
            case LogLevel::CRITICAL:
                $color = $this->colorRed;
                break;
        }
        return $color;

    }

    /**
     * Logs a log for the current level
     * @param string $level
     * @param string $message
     * @param array $context
     */
    final public function log($level, $message, array $context = []): void
    {
        if (defined("TINA4_DOCUMENT_ROOT")) {
            $this->documentRoot = TINA4_DOCUMENT_ROOT;
        }

        if (!is_string($message)) {
            $message .= "\n" . print_r($message, 1);
        }

        $debugLevel = implode("", self::$logLevel);

        $color = $this->getColor($level);
        if (defined("TINA4_DEBUG") && TINA4_DEBUG) {
            if (strpos($debugLevel, "all") !== false || strpos($debugLevel, $level) !== false) {
                $output = $color . strtoupper($level) . $this->colorReset . ":" . $message;
                if (!defined("TINA4_DEBUG_LENGTH")) {
                    define ("TINA4_DEBUG_LENGTH", 200);
                }
                error_log(substr($output,0, TINA4_DEBUG_LENGTH).((strlen($output) > TINA4_DEBUG_LENGTH) ? "..." : ""));
                if (!file_exists($this->documentRoot . "/log") && !mkdir($concurrentDirectory = $this->documentRoot . "/log", 0777, true) && !is_dir($concurrentDirectory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                }

                file_put_contents($this->documentRoot . "/log/".self::$alternativeFile, date("Y-m-d H:i:s: ") . $message . PHP_EOL, FILE_APPEND);

                if (!defined("TINA4_LOG_SIZE")) {
                    define("TINA4_LOG_SIZE", 1024*1024); //1MB
                }

                if (!defined("TINA4_LOG_ROTATIONS")) {
                    define("TINA4_LOG_ROTATIONS", 5); //Keep 5 rotations of files
                }

                //See if we need to rotate the log files
                $rotation = new Rotation();
                $rotation->compress() // Optional, compress the file after rotated. Accept level compression argument.
                         ->files(TINA4_LOG_ROTATIONS) // Optional, files are rotated 5 times before being removed. Default 5
                         ->minSize(TINA4_LOG_SIZE) // Optional, are rotated when they grow bigger than 1MB. Default 0
                         ->truncate() // Optional, truncate the original log file in place after creating a copy, instead of moving the old log file.
                         ->rotate($this->documentRoot . "/log/".self::$alternativeFile);
            }
        }
    }

    /**
     * Implements the emergency message
     * @param string $message
     * @param array $context
     */
    final public function emergency($message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Implements alert message
     * @param string $message
     * @param array $context
     */
    final public function alert($message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Implements critical error message
     * @param string $message
     * @param array $context
     */
    final public function critical($message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Implements error message
     * @param string $message
     * @param array $context
     */
    final public function error($message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Implements warning message
     * @param string $message
     * @param array $context
     */
    final public function warning($message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Implements notice message
     * @param string $message
     * @param array $context
     */
    final public function notice($message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Implements info message
     * @param string $message
     * @param array $context
     */
    final public function info($message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Implements debug message
     * @param string $message
     * @param array $context
     */
    final public function debug($message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}
