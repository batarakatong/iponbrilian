<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @if(auth()->user()->isAdmin())
        <div>
            <x-input-label for="user_id" value="Pegawai" />
            <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Pegawai --</option>
                @foreach($users ?? [] as $userOption)
                    <option value="{{ $userOption->id }}" @selected(old('user_id', optional($certificate)->user_id ?? auth()->id()) == $userOption->id)>
                        {{ $userOption->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
        </div>
    @endif

    <div>
        <x-input-label for="title" value="Judul / Nama Penghargaan" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', optional($certificate)->title)" required />
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="issuer" value="Penerbit" />
        <x-text-input id="issuer" name="issuer" type="text" class="mt-1 block w-full" :value="old('issuer', optional($certificate)->issuer)" />
        <x-input-error class="mt-2" :messages="$errors->get('issuer')" />
    </div>

    <div>
        <x-input-label for="reference_number" value="Nomor Referensi" />
        <x-text-input id="reference_number" name="reference_number" type="text" class="mt-1 block w-full" :value="old('reference_number', optional($certificate)->reference_number)" />
        <x-input-error class="mt-2" :messages="$errors->get('reference_number')" />
    </div>

    <div>
        <x-input-label for="issued_at" value="Tanggal Terbit" />
        <x-text-input id="issued_at" name="issued_at" type="date" class="mt-1 block w-full" :value="old('issued_at', optional(optional($certificate)->issued_at)->format('Y-m-d'))" />
        <x-input-error class="mt-2" :messages="$errors->get('issued_at')" />
    </div>

    <div>
        <x-input-label for="expired_at" value="Berlaku Hingga" />
        <x-text-input id="expired_at" name="expired_at" type="date" class="mt-1 block w-full" :value="old('expired_at', optional(optional($certificate)->expired_at)->format('Y-m-d'))" />
        <x-input-error class="mt-2" :messages="$errors->get('expired_at')" />
    </div>
</div>

<div>
    <x-input-label for="description" value="Catatan" />
    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', optional($certificate)->description) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

<div>
    <x-input-label for="document" value="Dokumen (jpg/png/pdf)" />
    <input id="document" name="document" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-gray-700" />
    @if(optional($certificate)->document_path)
        <p class="mt-1 text-xs text-gray-500">File saat ini: <a class="text-primary-600 underline" href="{{ Storage::disk('public')->url($certificate->document_path) }}" target="_blank">Lihat</a></p>
    @endif
    <x-input-error class="mt-2" :messages="$errors->get('document')" />
</div>
