<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Materi pelatihan & pengembangan kompetensi</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengembangan Kompetensi</h2>
            </div>
            @if($user->isAdmin())
                <a href="{{ route('trainings.create') }}" class="btn-primary">Tambah Materi</a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 uppercase tracking-wide text-[11px]">
                                <th class="py-2 px-2">Judul</th>
                                <th class="py-2 px-2">Pelatih</th>
                                <th class="py-2 px-2">Jadwal</th>
                                <th class="py-2 px-2">Lokasi</th>
                                <th class="py-2 px-2">Dokumen</th>
                                <th class="py-2 px-2">Wajib</th>
                                @if($user->isAdmin())
                                    <th class="py-2 px-2 text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($trainings as $training)
                                <tr class="text-slate-800">
                                    <td class="py-3 px-2 font-semibold">
                                        <a href="{{ route('trainings.show', $training) }}" class="text-primary-600 hover:underline">{{ $training->title }}</a>
                                    </td>
                                    <td class="py-3 px-2">{{ $training->trainer ?? '-' }}</td>
                                    <td class="py-3 px-2">
                                        {{ $training->start_date?->format('d M Y') ?? '-' }}
                                        @if($training->end_date)
                                            - {{ $training->end_date->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td class="py-3 px-2">{{ $training->location ?? '-' }}</td>
                                    <td class="py-3 px-2">
                                        @if($training->document_path)
                                            <a class="text-primary-600 text-xs underline" target="_blank" href="{{ Storage::disk('public')->url($training->document_path) }}">materi</a>
                                        @else
                                            <span class="text-xs text-slate-500">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-2">
                                        @if($training->is_mandatory)
                                            <span class="badge">Ya</span>
                                        @else
                                            <span class="text-xs text-slate-500">Opsional</span>
                                        @endif
                                    </td>
                                    @if($user->isAdmin())
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('trainings.edit', $training) }}" class="btn-secondary">Edit</a>
                                                <form action="{{ route('trainings.destroy', $training) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
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
                                    <td colspan="{{ $user->isAdmin() ? 7 : 6 }}" class="py-4 px-2 text-center text-slate-500">Belum ada materi pelatihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-slate-100">
                    {{ $trainings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
