<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-gray-500">Kelola akun & biodata</p>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil Pengguna
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 mb-2">Sertifikat</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            @forelse($certificates as $certificate)
                                <li class="flex justify-between">
                                    <span>{{ $certificate->title }}</span>
                                    <span class="text-gray-400">{{ $certificate->issued_at?->format('d M Y') }}</span>
                                </li>
                            @empty
                                <li class="text-gray-400">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 mb-2">Kenaikan Pangkat</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            @forelse($promotions as $promotion)
                                <li class="flex justify-between">
                                    <div>
                                        <span class="font-semibold">{{ $promotion->new_rank }}</span>
                                        <span class="text-gray-400"> ({{ $promotion->current_rank ?? 'N/A' }})</span>
                                    </div>
                                    <span class="text-gray-400">{{ $promotion->effective_date?->format('d M Y') }}</span>
                                </li>
                            @empty
                                <li class="text-gray-400">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 mb-2">Kenaikan Gaji</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            @forelse($salaryIncrements as $increment)
                                <li class="flex justify-between">
                                    <span>Rp{{ number_format($increment->amount, 0, ',', '.') }}</span>
                                    <span class="text-gray-400">{{ $increment->effective_date?->format('d M Y') }}</span>
                                </li>
                            @empty
                                <li class="text-gray-400">Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
