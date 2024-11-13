<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\confirm;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function truncate(string $model): void
    {
        if (! app()->isProduction()) {
            if (env('AUTO_SEED', false) || confirm('Want to truncate ' . class_basename($model) . ' table first', false)) {
                Schema::disableForeignKeyConstraints();
                $model::truncate();
                Schema::enableForeignKeyConstraints();
            }
        }
    }
}
