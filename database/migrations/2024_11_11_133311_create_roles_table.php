<?php

use App\Enum\RoleEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $cases = array_column(RoleEnum::cases(), 'value');
            $table->string('name')->unique()->comment(json_encode($cases, JSON_PRETTY_PRINT));
            $table->timestampsD();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
