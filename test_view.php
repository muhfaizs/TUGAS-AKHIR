<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Auth::loginUsingId(3);
$request = Illuminate\Http\Request::create('/orangtua/profile', 'GET');
app()->instance('request', $request);

$controller = new App\Http\Controllers\OrangTua\ProfileController();
$view = $controller->edit($request);
echo $view->render();
