<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('remember_token');
            $table->string('nip')->nullable()->unique()->after('role');
            $table->string('phone', 25)->nullable()->after('nip');
            $table->string('position')->nullable()->after('phone');
            $table->string('department')->nullable()->after('position');
            $table->date('birth_date')->nullable()->after('department');
            $table->text('address')->nullable()->after('birth_date');
            $table->text('bio')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'nip',
                'phone',
                'position',
                'department',
                'birth_date',
                'address',
                'bio',
            ]);
        });
    }
};
