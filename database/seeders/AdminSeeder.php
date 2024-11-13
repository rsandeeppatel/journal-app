<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\{Role, User};
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        parent::truncate(User::class);
        $role = Role::query()->firstWhere(['name' => RoleEnum::ADMIN->value]);
        User::query()->upsert(
            [
                [
                    'name' => 'Admin',
                    'email' => 'admin@mail.com',
                    'password' => Hash::make('Admin@123'),
                    'role_id' => $role->id
                ],
            ],
            ['email']
        );
    }
}
