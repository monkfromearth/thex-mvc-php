<?php

// Vendor AutoLoad

require_once 'vendor/autoload.php';
require_once 'core/Kernel.php';

// Core Autoload

foreach (glob("../core/Core/*.php") as $filename)
{
    require_once $filename;
}

// Middleware AutoLoad

foreach (glob("../core/Middlewares/*.php") as $filename)
{
    require_once $filename;
}

// Other Autoloads
require_once 'bootstrap.php';
require_once 'core/routes.php';

?>