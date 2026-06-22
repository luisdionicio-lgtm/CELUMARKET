<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$routes = $app['router']->getRoutes();
$names = [];
foreach ($routes as $route) {
    $name = $route->getName();
    if ($name) {
        $uri = $route->uri();
        $method = implode('|', $route->methods());
        $names[$name][] = "$method $uri";
    }
}
foreach ($names as $name => $items) {
    if (count($items) > 1) {
        echo "$name has " . count($items) . " routes:\n";
        foreach ($items as $item) {
            echo "  $item\n";
        }
    }
}
