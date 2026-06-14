<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

if (extension_loaded('pdo_sqlite')) {
    uses(RefreshDatabase::class);
}

test('super administrator can access kelola bidan but cannot access data ibu hamil', function () {
    if (! extension_loaded('pdo_sqlite')) {
        $this->markTestSkipped('Ekstensi PDO SQLite tidak aktif pada lingkungan PHP CLI ini.');
    }
    $superAdmin = User::create([
        'name' => 'super administrator',
        'email' => 'admin@satukia.com',
        'phone' => '081234567890',
        'role' => 'bidan',
        'nip' => '199001012026062001',
        'password' => bcrypt('Password123'),
        'status' => 'aktif',
    ]);

    $this->actingAs($superAdmin);

    $this->get(route('bidan.index'))->assertStatus(200);
    $this->get(route('ibu-hamil.index'))->assertStatus(403);
});

test('regular bidan can access data ibu hamil but cannot access kelola bidan', function () {
    if (! extension_loaded('pdo_sqlite')) {
        $this->markTestSkipped('Ekstensi PDO SQLite tidak aktif pada lingkungan PHP CLI ini.');
    }
    $regularBidan = User::create([
        'name' => 'Bidan Regular',
        'email' => 'bidan@satukia.com',
        'phone' => '081234567891',
        'role' => 'bidan',
        'nip' => '199001012026062002',
        'password' => bcrypt('Password123'),
        'status' => 'aktif',
    ]);

    $this->actingAs($regularBidan);

    $this->get(route('ibu-hamil.index'))->assertStatus(200);
    $this->get(route('bidan.index'))->assertStatus(403);
});

test('deactivated bidan cannot login', function () {
    if (! extension_loaded('pdo_sqlite')) {
        $this->markTestSkipped('Ekstensi PDO SQLite tidak aktif pada lingkungan PHP CLI ini.');
    }
    $deactivatedBidan = User::create([
        'name' => 'Bidan Inaktif',
        'email' => 'bidan.inaktif@satukia.com',
        'phone' => '081234567892',
        'role' => 'bidan',
        'nip' => '199001012026062003',
        'password' => bcrypt('Password123'),
        'status' => 'nonaktif',
    ]);

    $response = $this->post('/login', [
        'role' => 'bidan',
        'identity' => '199001012026062003',
        'password' => 'Password123',
    ]);

    $response->assertSessionHasErrors('identity');
    $this->assertGuest();
});
