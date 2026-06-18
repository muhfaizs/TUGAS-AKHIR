<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$bidan = App\Models\User::firstOrCreate(
    ['username' => 'bidankb'],
    [
        'name' => 'Bidan KB (Testing)',
        'email' => 'bidan.kbtest@satukia.com',
        'password' => Illuminate\Support\Facades\Hash::make('BidanKB123!'),
        'role' => 'bidan',
        'status' => 'active',
        'phone' => '081222333444',
        'nik' => '1234123412341234'
    ]
);
// Reset password just in case it already existed
$bidan->password = Illuminate\Support\Facades\Hash::make('BidanKB123!');
$bidan->save();

echo "Akun Bidan siap!\nUsername: {$bidan->username}\nPassword: BidanKB123!\n";
