<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

Kernel::loadConfig();

$capsule->addConnection(Kernel::config('db'));

$capsule->bootEloquent();
$capsule->setAsGlobal();

?>