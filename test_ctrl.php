<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
chdir('/var/www');
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
try {
    $c = new App\Http\Controllers\HomeController();
    $r = $c->index();
    echo 'Controller OK' . PHP_EOL;
} catch (Throwable $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    echo 'at ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
}
