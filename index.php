<?php

const TINA4_DOCUMENT_ROOT = "./";
const TINA4_DEBUG = true;


require_once "vendor/autoload.php";



const TINA4_LOG_CRITICAL = \Psr\Log\LogLevel::CRITICAL;
const TINA4_LOG_ERROR = \Psr\Log\LogLevel::ERROR;

\Tina4\Debug::$logLevel = ["all"];



$test / 10;

$me = 10;

$me / 0;

echo \Tina4\Debug::message("Testing", \Psr\Log\LogLevel::DEBUG);
echo \Tina4\Debug::message("Testing", \Psr\Log\LogLevel::WARNING);
echo \Tina4\Debug::message("Testing", \Psr\Log\LogLevel::ERROR);
echo \Tina4\Debug::message("Testing", \Psr\Log\LogLevel::INFO);
echo \Tina4\Debug::message("Testing", \Psr\Log\LogLevel::CRITICAL);

throw new Exception("Hello", 1111);


