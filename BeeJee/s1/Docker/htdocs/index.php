<?php
/**
 * Web application
 * @author Valentin Badiul S <ur5fes@ya.ru>
 */
use App\Kernel;

require __DIR__.'/vendor/autoload.php';
$routing = include(__DIR__.'/config/routing.php');
if (true != $routing) {
   exit('Error :: can not include ' . __DIR__.'/config/routing.php');
}

$kernel = new Kernel($routing);
$kernel->run();
