<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Daftar sertifikat & penghargaan</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sertifikat</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('certificates.create') }}" class="btn-primary">Tambah Sertifikat</a>
            </div>
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
                                <th class="py-2 px-2">Penerbit</th>
                                <th class="py-2 px-2">Terbit</th>
                                <th class="py-2 px-2">No. Referensi</th>
                                @if($user->isAdmin())
                                    <th class="py-2 px-2">Pegawai</th>
                                @endif
                                <th class="py-2 px-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($certificates as $certificate)
                                <tr class="text-slate-800">
                                    <td class="py-3 px-2 font-semibold">{{ $certificate->title }}</td>
                                    <td class="py-3 px-2">{{ $certificate->issuer ?? '-' }}</td>
                                    <td class="py-3 px-2">{{ $certificate->issued_at?->format('d M Y') ?? '-' }}</td>
                                    <td class="py-3 px-2 flex items-center gap-2">
                                        <span>{{ $certificate->reference_number ?? '-' }}</span>
                                        @if($certificate->document_path)
                                            <a class="text-primary-600 text-xs underline" target="_blank" href="{{ Storage::disk('public')->url($certificate->document_path) }}">dokumen</a>
                                        @endif
                                    </td>
                                    @if($user->isAdmin())
                                        <td class="py-3 px-2">{{ $certificate->user->name }}</td>
                                    @endif
                                    <td class="py-3 px-2 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('certificates.edit', $certificate) }}" class="btn-secondary">Edit</a>
                                            <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" onsubmit="return confirm('Hapus sertifikat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $user->isAdmin() ? 6 : 5 }}" class="py-4 px-2 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-slate-100">
                    {{ $certificates->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
