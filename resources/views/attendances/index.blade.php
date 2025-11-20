<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Statistik kedisiplinan & absensi</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kedisiplinan</h2>
            </div>
            @if($user->isAdmin())
                <a href="{{ route('attendances.create') }}" class="btn-primary">Tambah Catatan</a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $labelMap = [
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'leave' => 'Izin',
                        'absent' => 'Absen',
                    ];
                @endphp
                @foreach($statusCounts as $key => $value)
                    <div class="card">
                        <p class="text-xs text-slate-500 uppercase">{{ $labelMap[$key] ?? $key }}</p>
                        <p class="text-3xl font-semibold text-slate-800">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($user->isAdmin())
                <div class="card">
                    <form method="GET" action="{{ route('attendances.index') }}" class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="user-filter" value="Tampilkan untuk pegawai" />
                            <select id="user-filter" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500" onchange="this.form.submit()">
                                <option value="">Semua pegawai</option>
                                @foreach($filterUsers as $optionUser)
                                    <option value="{{ $optionUser->id }}" @selected((string) $selectedUserId === (string) $optionUser->id)>{{ $optionUser->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(request()->filled('user_id'))
                            <a href="{{ route('attendances.index') }}" class="btn-secondary">Reset</a>
                        @endif
                    </form>
                </div>
            @endif

            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 uppercase tracking-wide text-[11px]">
                                <th class="py-2 px-2">Bulan</th>
                                @if($user->isAdmin())
                                    <th class="py-2 px-2">Pegawai</th>
                                @endif
                                <th class="py-2 px-2">Hadir</th>
                                <th class="py-2 px-2">Terlambat</th>
                                <th class="py-2 px-2">Izin</th>
                                <th class="py-2 px-2">Absen</th>
                                <th class="py-2 px-2">Dokumen</th>
                                @if($user->isAdmin())
                                    <th class="py-2 px-2 text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($attendances as $attendance)
                                <tr class="text-slate-800">
                                    <td class="py-3 px-2">{{ $attendance->month->format('F Y') }}</td>
                                    @if($user->isAdmin())
                                        <td class="py-3 px-2">
                                            {{ optional($attendance->user)->name ?? 'Tidak diketahui' }}
                                        </td>
                                    @endif
                                    <td class="py-3 px-2">{{ $attendance->present_count }}</td>
                                    <td class="py-3 px-2">{{ $attendance->late_count }}</td>
                                    <td class="py-3 px-2">{{ $attendance->leave_count }}</td>
                                    <td class="py-3 px-2">{{ $attendance->absent_count }}</td>
                                    <td class="py-3 px-2">
                                        @if($attendance->document_path)
                                            <a class="text-primary-600 text-xs underline" target="_blank" href="{{ Storage::disk('public')->url($attendance->document_path) }}">Lihat</a>
                                        @else
                                            <span class="text-xs text-slate-500">-</span>
                                        @endif
                                    </td>
                                    @if($user->isAdmin())
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('attendances.edit', $attendance) }}" class="btn-secondary">Edit</a>
                                                <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $user->isAdmin() ? 8 : 6 }}" class="py-4 px-2 text-center text-slate-500">Belum ada data absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-slate-100">
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
