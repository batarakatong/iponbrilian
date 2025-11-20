<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Perbarui data kenaikan pangkat</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kenaikan Pangkat</h2>
            </div>
            <a href="{{ route('promotions.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('promotions.update', $promotion) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if($users->count())
                        <div>
                            <x-input-label for="user_id" value="Pegawai" />
                            <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($users as $userOption)
                                    <option value="{{ $userOption->id }}" @selected(old('user_id', $promotion->user_id) == $userOption->id)>{{ $userOption->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="current_rank" value="Pangkat Sebelumnya" />
                            <x-text-input id="current_rank" name="current_rank" type="text" class="mt-1 block w-full" :value="old('current_rank', $promotion->current_rank)" />
                            <x-input-error class="mt-2" :messages="$errors->get('current_rank')" />
                        </div>
                        <div>
                            <x-input-label for="new_rank" value="Pangkat Baru" />
                            <x-text-input id="new_rank" name="new_rank" type="text" class="mt-1 block w-full" :value="old('new_rank', $promotion->new_rank)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('new_rank')" />
                        </div>
                        <div>
                            <x-input-label for="effective_date" value="Tanggal Efektif" />
                            <x-text-input id="effective_date" name="effective_date" type="date" class="mt-1 block w-full" :value="old('effective_date', optional($promotion->effective_date)->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('effective_date')" />
                        </div>
                        <div>
                            <x-input-label for="document_number" value="Nomor Dokumen" />
                            <x-text-input id="document_number" name="document_number" type="text" class="mt-1 block w-full" :value="old('document_number', $promotion->document_number)" />
                            <x-input-error class="mt-2" :messages="$errors->get('document_number')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $promotion->notes) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                    </div>

                    <div>
                        <x-input-label for="document" value="Dokumen (jpg/png/pdf)" />
                        <input id="document" name="document" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-gray-700" />
                        @if($promotion->document_path)
                            <p class="mt-1 text-xs text-gray-500">File saat ini: <a class="text-primary-600 underline" href="{{ Storage::disk('public')->url($promotion->document_path) }}" target="_blank">Lihat</a></p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('document')" />
                    </div>

                    <div class="flex justify-start gap-3">
                        <x-primary-button>Update</x-primary-button>
                        <a href="{{ route('promotions.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
