<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\Promotion;
use App\Models\SalaryIncrement;
use App\Models\Training;
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
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
                'nip' => '19800001',
                'phone' => '0800000001',
                'position' => 'Kepala Bagian',
                'department' => 'SDM',
            ],
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'nip' => '19800002',
                'phone' => '0800000002',
                'position' => 'HR Administrator',
                'department' => 'SDM',
            ],
        );

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Pegawai Contoh',
                'password' => bcrypt('password'),
                'role' => 'user',
                'nip' => '19800003',
                'phone' => '0800000003',
                'position' => 'Staf',
                'department' => 'Operasional',
            ],
        );

        $trainings = collect([
            ['title' => 'Pelatihan Leadership', 'trainer' => 'Instruktur A', 'start_date' => now()->addWeeks(1), 'end_date' => now()->addWeeks(2), 'location' => 'Ruang Rapat Utama', 'is_mandatory' => true],
            ['title' => 'Penguatan Budaya Kerja', 'trainer' => 'Instruktur B', 'start_date' => now()->addWeeks(3), 'location' => 'Zoom', 'is_mandatory' => false],
        ])->map(fn ($data) => Training::updateOrCreate(
            ['title' => $data['title']],
            array_merge(['description' => 'Materi auto seed.'], $data),
        ));

        Certificate::updateOrCreate(
            ['title' => 'Certified Professional'],
            ['user_id' => $user->id, 'issuer' => 'Lembaga Sertifikasi', 'issued_at' => now()->subMonths(2)]
        );

        Promotion::updateOrCreate(
            ['user_id' => $user->id, 'new_rank' => 'Senior Staf'],
            ['current_rank' => 'Staf', 'effective_date' => now()->addMonth()]
        );

        SalaryIncrement::updateOrCreate(
            ['user_id' => $user->id, 'amount' => 750000],
            ['effective_date' => now()->addMonths(2), 'reason' => 'Kenaikan berkala tahunan', 'approved_by' => 'Direktur SDM']
        );

        Attendance::updateOrCreate(
            ['month' => now()->startOfMonth()->toDateString()],
            [
                'present_count' => 20,
                'late_count' => 2,
                'leave_count' => 1,
                'absent_count' => 1,
            ]
        );
    }
}
