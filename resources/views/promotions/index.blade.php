<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Riwayat kenaikan pangkat per pegawai</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kenaikan Pangkat</h2>
            </div>
            @if($user->isAdmin())
                <a href="{{ route('promotions.create') }}" class="btn-primary">Tambah Data</a>
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
                                @if($user->isAdmin())
                                    <th class="py-2 px-2">Pegawai</th>
                                @endif
                                <th class="py-2 px-2">Dari</th>
                                <th class="py-2 px-2">Ke</th>
                                <th class="py-2 px-2">Efektif</th>
                                <th class="py-2 px-2">No Dokumen</th>
                                @if($user->isAdmin())
                                    <th class="py-2 px-2 text-right">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($promotions as $promotion)
                                <tr class="text-slate-800">
                                    @if($user->isAdmin())
                                        <td class="py-3 px-2">{{ $promotion->user->name }}</td>
                                    @endif
                                    <td class="py-3 px-2">{{ $promotion->current_rank ?? '-' }}</td>
                                    <td class="py-3 px-2 font-semibold">{{ $promotion->new_rank }}</td>
                                    <td class="py-3 px-2">{{ $promotion->effective_date?->format('d M Y') ?? '-' }}</td>
                                    <td class="py-3 px-2 flex items-center gap-2">
                                        <span>{{ $promotion->document_number ?? '-' }}</span>
                                        @if($promotion->document_path)
                                            <a class="text-primary-600 text-xs underline" target="_blank" href="{{ Storage::disk('public')->url($promotion->document_path) }}">dokumen</a>
                                        @endif
                                    </td>
                                    @if($user->isAdmin())
                                        <td class="py-3 px-2 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('promotions.edit', $promotion) }}" class="btn-secondary">Edit</a>
                                                <form action="{{ route('promotions.destroy', $promotion) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
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
                                    <td colspan="{{ $user->isAdmin() ? 6 : 4 }}" class="py-4 px-2 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-slate-100">
                    {{ $promotions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
