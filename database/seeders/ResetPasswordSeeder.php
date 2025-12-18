<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset all users password to 'password' with must_change_password = true
        $users = User::all();
        
        foreach ($users as $user) {
            $user->password = Hash::make('password');
            $user->must_change_password = true;
            $user->save();
            
            echo "Password reset untuk: {$user->email} (role: {$user->role}) - must_change: YES\n";
        }
        
        echo "\n✅ Semua password telah direset ke: password\n";
        echo "⚠️  Setelah login, user akan diminta untuk mengganti password default\n";
    }
}
