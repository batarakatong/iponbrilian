<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Tambah kenaikan gaji berkala</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kenaikan Gaji</h2>
            </div>
            <a href="{{ route('salary-increments.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('salary-increments.store') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="user_id" value="Pegawai" />
                            <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($users as $userOption)
                                    <option value="{{ $userOption->id }}" @selected(old('user_id') == $userOption->id)>{{ $userOption->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>
                        <div>
                            <x-input-label for="amount" value="Nominal" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('amount')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>
                        <div>
                            <x-input-label for="effective_date" value="Tanggal Efektif" />
                            <x-text-input id="effective_date" name="effective_date" type="date" class="mt-1 block w-full" :value="old('effective_date')" />
                            <x-input-error class="mt-2" :messages="$errors->get('effective_date')" />
                        </div>
                        <div>
                            <x-input-label for="approved_by" value="Disetujui Oleh" />
                            <x-text-input id="approved_by" name="approved_by" type="text" class="mt-1 block w-full" :value="old('approved_by')" />
                            <x-input-error class="mt-2" :messages="$errors->get('approved_by')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="reason" value="Catatan / Alasan" />
                        <textarea id="reason" name="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('reason') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                    </div>

                    <div>
                        <x-input-label for="document" value="Dokumen (jpg/png/pdf)" />
                        <input id="document" name="document" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-gray-700" />
                        <x-input-error class="mt-2" :messages="$errors->get('document')" />
                    </div>

                    <div class="flex justify-start gap-3">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('salary-increments.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
