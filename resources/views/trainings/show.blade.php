<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Detail materi pelatihan</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $training->title }}</h2>
            </div>
            <a href="{{ route('trainings.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-700">
                    <div>
                        <p class="text-slate-500 text-xs uppercase">Pengajar</p>
                        <p class="font-semibold text-slate-800">{{ $training->trainer ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs uppercase">Lokasi</p>
                        <p class="font-semibold text-slate-800">{{ $training->location ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs uppercase">Jadwal</p>
                        <p class="font-semibold text-slate-800">
                            {{ $training->start_date?->format('d M Y') ?? '-' }}
                            @if($training->end_date)
                                - {{ $training->end_date->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase">Status</p>
                    <p class="font-semibold text-slate-800">
                        {{ $training->is_mandatory ? 'Wajib' : 'Opsional' }}
                    </p>
                </div>
                @if($training->document_path)
                    <div>
                        <p class="text-slate-500 text-xs uppercase">Dokumen</p>
                        <p class="font-semibold text-slate-800"><a href="{{ Storage::disk('public')->url($training->document_path) }}" target="_blank" class="text-primary-600 underline">Lihat Dokumen</a></p>
                    </div>
                @endif
            </div>

                <div>
                    <p class="text-slate-500 text-xs uppercase mb-1">Deskripsi</p>
                    <p class="text-slate-700">{{ $training->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
