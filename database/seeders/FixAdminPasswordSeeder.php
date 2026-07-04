<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAdminPasswordSeeder extends Seeder
{
    public function run(): void
    {
        // Fix admin user - ensure password is properly hashed
        $admin = User::where('username', 'admin')->first();
        
        if ($admin) {
            $admin->password = Hash::make('password123');
            $admin->save();
            echo "Admin password has been rehashed successfully.\n";
        } else {
            echo "Admin user not found.\n";
        }
    }
}