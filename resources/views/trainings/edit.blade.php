<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Perbarui materi pelatihan</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Materi</h2>
            </div>
            <a href="{{ route('trainings.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('trainings.update', $training) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="title" value="Judul" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $training->title)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div>
                            <x-input-label for="trainer" value="Pengajar / Trainer" />
                            <x-text-input id="trainer" name="trainer" type="text" class="mt-1 block w-full" :value="old('trainer', $training->trainer)" />
                            <x-input-error class="mt-2" :messages="$errors->get('trainer')" />
                        </div>
                        <div>
                            <x-input-label for="start_date" value="Mulai" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', optional($training->start_date)->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>
                        <div>
                            <x-input-label for="end_date" value="Selesai" />
                            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date', optional($training->end_date)->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>
                        <div>
                            <x-input-label for="location" value="Lokasi" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $training->location)" />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>
                        <div class="flex items-center gap-3 mt-6">
                            <input id="is_mandatory" name="is_mandatory" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('is_mandatory', $training->is_mandatory))>
                            <label for="is_mandatory" class="text-sm text-gray-700">Tandai sebagai wajib diikuti</label>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="document" value="Dokumen (jpg/png/pdf)" />
                        <input id="document" name="document" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-gray-700" />
                        @if($training->document_path)
                            <p class="mt-1 text-xs text-gray-500">File saat ini: <a class="text-primary-600 underline" href="{{ Storage::disk('public')->url($training->document_path) }}" target="_blank">Lihat</a></p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('document')" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $training->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex justify-start gap-3">
                        <x-primary-button>Update</x-primary-button>
                        <a href="{{ route('trainings.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
