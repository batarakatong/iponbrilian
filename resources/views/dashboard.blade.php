<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Ringkasan aplikasi</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </div>
            <div class="text-sm text-slate-500">
                Akses: <span class="font-semibold text-primary-600">{{ $isAdmin ? 'Administrator' : 'Pengguna' }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Sertifikat</p>
                            <p class="text-3xl font-semibold text-slate-800">{{ $certificatesCount }}</p>
                        </div>
                        <span class="badge">Docs</span>
                    </div>
                </div>
                <div class="card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Materi Pelatihan</p>
                            <p class="text-3xl font-semibold text-slate-800">{{ $trainingsCount }}</p>
                        </div>
                        <span class="badge">Learn</span>
                    </div>
                </div>
                <div class="card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Kenaikan Pangkat</p>
                            <p class="text-3xl font-semibold text-slate-800">{{ $promotionsCount }}</p>
                        </div>
                        <span class="badge">Karir</span>
                    </div>
                </div>
                <div class="card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Kenaikan Gaji</p>
                            <p class="text-3xl font-semibold text-slate-800">{{ $salaryCount }}</p>
                        </div>
                        <span class="badge">Gaji</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="card xl:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Statistik Kedisiplinan</p>
                            <h3 class="text-lg font-semibold text-slate-800">Absensi 6 Bulan Terakhir</h3>
                        </div>
                    </div>
                    <div class="h-72">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-500">Ringkasan Status</p>
                            <h3 class="text-lg font-semibold text-slate-800">Per Status</h3>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $statusLabels = [
                                'present' => 'Hadir',
                                'late' => 'Terlambat',
                                'leave' => 'Izin',
                                'absent' => 'Absen',
                            ];
                        @endphp
                        @foreach ($statusLabels as $key => $label)
                            <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                                <p class="text-xs text-slate-500">{{ $label }}</p>
                                <p class="text-2xl font-semibold text-slate-800">{{ $attendanceStats[$key] ?? 0 }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Materi Pelatihan Terbaru</h3>
                        <a href="{{ route('trainings.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Lihat semua</a>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        @forelse ($recentTrainings as $training)
                            <li class="py-3 flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $training->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $training->start_date?->format('d M Y') }} @if($training->end_date) - {{ $training->end_date->format('d M Y') }} @endif</p>
                                </div>
                                @if($training->is_mandatory)
                                    <span class="text-[11px] px-2 py-1 rounded-full bg-primary-50 text-primary-700">wajib</span>
                                @endif
                            </li>
                        @empty
                            <li class="py-3 text-sm text-slate-500">Belum ada materi pelatihan.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Sertifikat / Penghargaan</h3>
                        <a href="{{ route('certificates.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Kelola</a>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        @forelse ($recentCertificates as $certificate)
                            <li class="py-3 flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $certificate->title }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $certificate->issuer ?? 'Penerbit tidak ada' }}
                                        @if($isAdmin)
                                            · {{ $certificate->user->name }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs text-slate-500">{{ $certificate->issued_at?->format('d M Y') }}</span>
                            </li>
                        @empty
                            <li class="py-3 text-sm text-slate-500">Belum ada sertifikat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800">Kenaikan Pangkat</h3>
                    <a href="{{ route('promotions.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Kelola</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 uppercase tracking-wide text-[11px]">
                                <th class="py-2">Pegawai</th>
                                <th class="py-2">Dari</th>
                                <th class="py-2">Ke</th>
                                <th class="py-2">Efektif</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentPromotions as $promotion)
                                <tr class="text-slate-800">
                                    <td class="py-3">{{ $promotion->user->name }}</td>
                                    <td class="py-3">{{ $promotion->current_rank ?? '-' }}</td>
                                    <td class="py-3 font-semibold">{{ $promotion->new_rank }}</td>
                                    <td class="py-3">{{ $promotion->effective_date?->format('d M Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 text-slate-500">Belum ada data kenaikan pangkat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartEl = document.getElementById('attendanceChart');
        if (chartEl) {
            const chartData = @json($attendanceByMonth);
            const labels = chartData.map(item => new Date(item.month).toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }));
            const present = chartData.map(item => Number(item.present ?? 0));
            const late = chartData.map(item => Number(item.late ?? 0));
            const leave = chartData.map(item => Number(item.leave_count ?? 0));
            const absent = chartData.map(item => Number(item.absent ?? 0));

            new Chart(chartEl, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        { label: 'Hadir', data: present, borderColor: '#0f9bd7', backgroundColor: 'rgba(15, 155, 215, 0.15)', tension: 0.3, fill: true },
                        { label: 'Terlambat', data: late, borderColor: '#f97316', backgroundColor: 'rgba(249, 115, 22, 0.15)', tension: 0.3, fill: true },
                        { label: 'Izin', data: leave, borderColor: '#22c55e', backgroundColor: 'rgba(34, 197, 94, 0.15)', tension: 0.3, fill: true },
                        { label: 'Absen', data: absent, borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.15)', tension: 0.3, fill: true },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                },
            });
        }
    </script>
</x-app-layout>
