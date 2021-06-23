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

\Tina4\Debug::message("Testing", \Psr\Log\LogLevel::DEBUG);
\Tina4\Debug::message("Testing", \Psr\Log\LogLevel::WARNING);
\Tina4\Debug::message("Testing", \Psr\Log\LogLevel::ERROR);
\Tina4\Debug::message("Testing", \Psr\Log\LogLevel::INFO);
\Tina4\Debug::message("Testing", \Psr\Log\LogLevel::CRITICAL);

throw new Exception("Hello", 1111);


