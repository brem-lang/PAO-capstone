<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Regine Truya',
            'email' => 'reginetruya@gmail.com',
            'role' => 'super-attorney',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'HEAD ATTY',
            'email' => 'attorneysample03@gmail.com',
            'role' => 'super-attorney',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Leangel Serdan',
            'email' => 'staffleangel30@gmail.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'ATY LILET',
            'email' => 'attylilet@gmail.com',
            'role' => 'attorney',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Ammie',
            'email' => 'staffsample01@gmail.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'JOBERT ICALINA',
            'email' => 'joberticalina604@gmail.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
        ]);

        $this->call(
            UserSeeder::class
        );
        User::factory()->create([
            'name' => 'EMMA ATTY',
            'email' => 'attorneyacc02@gmail.com',
            'role' => 'attorney',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'EMMA STAFF',
            'email' => 'staffacc649@gmail.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
        ]);
    }
}
