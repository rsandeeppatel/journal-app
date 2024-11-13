<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enum\RoleEnum;

class RoleSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        parent::truncate(Role::class);

        Role::query()->upsert(
            [
                ['name' => RoleEnum::ADMIN->value],
                ['name' => RoleEnum::USER->value]
            ],
            ['name'],
            ['name'],
        );
    }
}
