<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Perbarui data absensi</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Absensi</h2>
            </div>
            <a href="{{ route('attendances.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('attendances.update', $attendance) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="user_id" value="Pegawai" />
                        <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($users as $optionUser)
                                <option value="{{ $optionUser->id }}" @selected(old('user_id', $attendance->user_id) == $optionUser->id)>{{ $optionUser->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="month" value="Bulan" />
                            <x-text-input id="month" name="month" type="month" class="mt-1 block w-full" :value="old('month', optional($attendance->month)->format('Y-m'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('month')" />
                        </div>
                        <div>
                            <x-input-label for="present_count" value="Jumlah Hadir" />
                            <x-text-input id="present_count" name="present_count" type="number" min="0" class="mt-1 block w-full" :value="old('present_count', $attendance->present_count)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('present_count')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="late_count" value="Jumlah Terlambat" />
                            <x-text-input id="late_count" name="late_count" type="number" min="0" class="mt-1 block w-full" :value="old('late_count', $attendance->late_count)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('late_count')" />
                        </div>
                        <div>
                            <x-input-label for="leave_count" value="Jumlah Izin" />
                            <x-text-input id="leave_count" name="leave_count" type="number" min="0" class="mt-1 block w-full" :value="old('leave_count', $attendance->leave_count)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('leave_count')" />
                        </div>
                        <div>
                            <x-input-label for="absent_count" value="Jumlah Absen" />
                            <x-text-input id="absent_count" name="absent_count" type="number" min="0" class="mt-1 block w-full" :value="old('absent_count', $attendance->absent_count)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('absent_count')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="document" value="Dokumen (jpg/png/pdf)" />
                        <input id="document" name="document" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-gray-700" />
                        @if($attendance->document_path)
                            <p class="mt-1 text-xs text-gray-500">File saat ini: <a class="text-primary-600 underline" href="{{ Storage::disk('public')->url($attendance->document_path) }}" target="_blank">Lihat</a></p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('document')" />
                    </div>

                    <div class="flex justify-start gap-3">
                        <x-primary-button>Update</x-primary-button>
                        <a href="{{ route('attendances.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
