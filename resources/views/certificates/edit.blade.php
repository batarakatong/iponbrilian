<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Perbarui sertifikat</p>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Sertifikat</h2>
            </div>
            <a href="{{ route('certificates.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form method="POST" action="{{ route('certificates.update', $certificate) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('certificates.partials.form', ['certificate' => $certificate])
                    <div class="flex justify-start gap-3">
                        <x-primary-button>Update</x-primary-button>
                        <a href="{{ route('certificates.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
