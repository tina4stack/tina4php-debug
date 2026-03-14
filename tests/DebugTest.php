<?php

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;

require_once __DIR__ . '/../vendor/autoload.php';

class DebugTest extends TestCase
{
    /**
     * Test that Debug::message is a callable static method
     */
    public function testMessageMethodExists(): void
    {
        $this->assertTrue(
            method_exists(\Tina4\Debug::class, 'message'),
            'Debug::message method should exist'
        );
        $this->assertTrue(
            is_callable([\Tina4\Debug::class, 'message']),
            'Debug::message should be callable'
        );
    }

    /**
     * Test that the \Tina4\Debug class exists and implements LoggerInterface
     */
    public function testDebugClassExists(): void
    {
        $this->assertTrue(
            class_exists(\Tina4\Debug::class),
            '\Tina4\Debug class should exist'
        );

        $reflection = new \ReflectionClass(\Tina4\Debug::class);
        $this->assertTrue(
            $reflection->implementsInterface(\Psr\Log\LoggerInterface::class),
            '\Tina4\Debug should implement Psr\Log\LoggerInterface'
        );
    }

    /**
     * Test that expected log level constants are defined in Initialize.php
     */
    public function testLogLevelConstants(): void
    {
        $this->assertTrue(defined('TINA4_LOG_EMERGENCY'), 'TINA4_LOG_EMERGENCY should be defined');
        $this->assertTrue(defined('TINA4_LOG_ALERT'), 'TINA4_LOG_ALERT should be defined');
        $this->assertTrue(defined('TINA4_LOG_CRITICAL'), 'TINA4_LOG_CRITICAL should be defined');
        $this->assertTrue(defined('TINA4_LOG_ERROR'), 'TINA4_LOG_ERROR should be defined');
        $this->assertTrue(defined('TINA4_LOG_WARNING'), 'TINA4_LOG_WARNING should be defined');
        $this->assertTrue(defined('TINA4_LOG_NOTICE'), 'TINA4_LOG_NOTICE should be defined');
        $this->assertTrue(defined('TINA4_LOG_INFO'), 'TINA4_LOG_INFO should be defined');
        $this->assertTrue(defined('TINA4_LOG_DEBUG'), 'TINA4_LOG_DEBUG should be defined');
        $this->assertTrue(defined('TINA4_LOG_ALL'), 'TINA4_LOG_ALL should be defined');

        // Verify values match PSR-3 log level strings
        $this->assertSame('emergency', TINA4_LOG_EMERGENCY);
        $this->assertSame('alert', TINA4_LOG_ALERT);
        $this->assertSame('critical', TINA4_LOG_CRITICAL);
        $this->assertSame('error', TINA4_LOG_ERROR);
        $this->assertSame('warning', TINA4_LOG_WARNING);
        $this->assertSame('notice', TINA4_LOG_NOTICE);
        $this->assertSame('info', TINA4_LOG_INFO);
        $this->assertSame('debug', TINA4_LOG_DEBUG);
        $this->assertSame('all', TINA4_LOG_ALL);
    }

    /**
     * Test that static method calls on Debug do not throw exceptions.
     * TINA4_DEBUG is not defined here, so log() will skip file I/O.
     */
    public function testStaticMethodCalls(): void
    {
        // Reset logger state to ensure clean test
        \Tina4\Debug::$logger = null;

        // These should all execute without throwing
        \Tina4\Debug::message('test info message', LogLevel::INFO);
        \Tina4\Debug::message('test error message', LogLevel::ERROR);
        \Tina4\Debug::message('test warning message', LogLevel::WARNING);
        \Tina4\Debug::message('test debug message', LogLevel::DEBUG);

        // Also test instance methods via the PSR-3 interface
        $debug = new \Tina4\Debug();
        $debug->info('instance info');
        $debug->error('instance error');
        $debug->warning('instance warning');
        $debug->debug('instance debug');
        $debug->notice('instance notice');
        $debug->alert('instance alert');
        $debug->critical('instance critical');
        $debug->emergency('instance emergency');

        // If we got here without exceptions, the test passes
        $this->assertTrue(true);
    }
}
