<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_default_admin_account_can_login(): void
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@perpustakaan.com';
        $user->nama_lengkap = 'Administrator';
        $user->password = Hash::make('password123');
        $user->status = 'aktif';
        $user->save();

        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertTrue(auth()->attempt(['username' => 'admin', 'password' => 'password123']));
    }
}
