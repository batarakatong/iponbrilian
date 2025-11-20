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
            $table->string('document_path')->nullable()->after('bio');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->string('document_path')->nullable()->after('description');
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->string('document_path')->nullable()->after('is_mandatory');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->string('document_path')->nullable()->after('notes');
        });

        Schema::table('salary_increments', function (Blueprint $table) {
            $table->string('document_path')->nullable()->after('approved_by');
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
            if (Schema::hasColumn('attendances', 'attendance_date')) {
                $table->dropUnique('attendances_user_id_attendance_date_unique');
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'user_id')) {
                $table->dropColumn(['user_id']);
            }
            if (Schema::hasColumn('attendances', 'attendance_date')) {
                $table->dropColumn(['attendance_date']);
            }
            if (Schema::hasColumn('attendances', 'status')) {
                $table->dropColumn(['status']);
            }
            if (Schema::hasColumn('attendances', 'notes')) {
                $table->dropColumn(['notes']);
            }

            $table->date('month')->after('id');
            $table->unsignedInteger('present_count')->default(0);
            $table->unsignedInteger('late_count')->default(0);
            $table->unsignedInteger('leave_count')->default(0);
            $table->unsignedInteger('absent_count')->default(0);
            $table->string('document_path')->nullable();
            $table->unique('month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique(['month']);
            $table->dropColumn([
                'month',
                'present_count',
                'late_count',
                'leave_count',
                'absent_count',
                'document_path',
            ]);

            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('attendance_date')->nullable();
            $table->string('status')->default('present');
            $table->text('notes')->nullable();
            $table->unique(['user_id', 'attendance_date']);
        });

        Schema::table('salary_increments', function (Blueprint $table) {
            $table->dropColumn('document_path');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('document_path');
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('document_path');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('document_path');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('document_path');
        });
    }
};
