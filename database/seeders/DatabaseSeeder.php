<?php

namespace Database\Seeders;

use App\Models\User;

class DatabaseSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class
        ]);
    }
}
