<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::find(1);
$u->update(['status' => 'active']);
echo "Status superadmin di DB setelah update manual: " . $u->status . "\n";
