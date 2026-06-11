<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$a = App\Models\Anak::find(2);
$a->update(['alamat_domisili' => 'Test', 'nomor_kontak_darurat' => 'Test']);
echo $a->alamat_domisili;
