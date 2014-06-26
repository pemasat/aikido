<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

// Let bootstrap create Dependency Injection container.
$container = require __DIR__ . '/../app/bootstrap.php';

define('WWW_DIR', __DIR__);
define('GALLERIES_DIR', WWW_DIR . '/galleries');
define('GALLERIES_TEMP_DIR', WWW_DIR . '/../temp/galleries');


$container->getService('application')->run();
