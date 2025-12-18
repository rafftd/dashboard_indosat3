<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing users first to avoid duplicates
        User::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create users for each role with must_change_password = false for testing
        User::create([
            'name' => 'Administrasi',
            'email' => 'administrasi@indosat.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_ADMINISTRASI,
            'must_change_password' => true, // Set to true so user must change password
        ]);

        User::create([
            'name' => 'Designer',
            'email' => 'designer@indosat.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_DESIGNER,
            'must_change_password' => true, // Set to true so user must change password
        ]);

        User::create([
            'name' => 'Vendor Team',
            'email' => 'vendor@indosat.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_VENDOR,
            'must_change_password' => true, // Set to true so user must change password
        ]);

        User::create([
            'name' => 'Marcomm Branch',
            'email' => 'marcomm@indosat.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_MARCOMM_BRANCH,
            'must_change_password' => true, // Set to true so user must change password
        ]);

        // Seed all data
        $this->call([
            PurchaseOrderSeeder::class,
            POSMRequestSeeder::class,
            VendorShipmentSeeder::class,
            MatproReceiptSeeder::class,
        ]);
    }
}
