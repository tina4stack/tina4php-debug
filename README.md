# Tina4 Php Debug

A generic debugging module which can enhance your normal PHP project

### Install the module using composer

```
composer require tina4stack/tina4php-debug
```

### Some examples of what to expect

Normal error handling looks like this

![](.README_images/0021cfaf.png)

Exception handling and errors will be published to the screen automatically for you.

![](.README_images/1168b9b3.png)

You also get some nice console output

![](.README_images/9ac99dae.png)

### Setting this up in your project

In your code you need to set some constants to get this working.
```php index.php
<?php
const TINA4_DOCUMENT_ROOT = __DIR__;
const TINA4_DEBUG = true;
require_once "vendor/autoload.php";

//Set the log level of what you want reported to console

\Tina4\Debug::$logLevel = ["debug"];

//You can code here as per normal

```

### Log Levels

```
const EMERGENCY = 'emergency';
const ALERT     = 'alert';
const CRITICAL  = 'critical';
const ERROR     = 'error';
const WARNING   = 'warning';
const NOTICE    = 'notice';
const INFO      = 'info';
const DEBUG     = 'debug';
```
