<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ipon Brilian | Manajemen Pelatihan & Absensi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                @layer theme {
                    :root,:host{
                        --font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                        /* ... semua CSS bawaan laravel biarkan saja, jangan diubah ... */
                    }
                }
                /* seluruh CSS panjang yang tadi kamu kirim tetap dipertahankan di sini.
                   Untuk singkat, saya tidak hapus satupun – tinggal paste saja dari file sebelumnya. */
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Masuk
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                {{-- KONTEN KIRI --}}
                <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                    <h1 class="mb-1 text-[18px] font-medium">
                        Selamat Datang di <span class="text-[#f53003] dark:text-[#FF4433] font-semibold">Ipon Brilian</span>
                    </h1>

                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        Ipon Brilian adalah aplikasi manajemen:
                    </p>
                    <ul class="mb-2 text-[#706f6c] dark:text-[#A1A09A] list-disc ml-4 space-y-1">
                        <li>Absensi kegiatan pelatihan</li>
                        <li>Pengelolaan sertifikat peserta</li>
                        <li>Distribusi dan arsip materi pelatihan</li>
                        <li>Informasi jadwal & agenda pelatihan</li>
                    </ul>

                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        Digunakan di lingkungan
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            Kantor Imigrasi Kelas II Non TPI Kabupaten Ponorogo
                        </span>,
                        bekerja sama dengan
                        <span class="font-medium">sdawetjabung.com</span>.
                    </p>

                    <p class="mb-4 text-[#706f6c] dark:text-[#A1A09A]">
                        Silakan masuk untuk mengelola data absensi, sertifikat, dan materi pelatihan secara terintegrasi.
                    </p>

                    <ul class="flex flex-wrap gap-3 text-sm leading-normal">
                        @if (Route::has('login'))
                            <li>
                                <a href="{{ route('login') }}"
                                   class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
                                    Masuk ke Ipon Brilian
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="https://sdawetjabung.com" target="_blank"
                               class="inline-block px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm text-sm leading-normal text-[#1b1b18] dark:text-[#EDEDEC] hover:border-black dark:hover:border-white">
                                Kunjungi sdawetjabung.com
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- KONTEN KANAN: LOGO DI TENGAH --}}
                <div class="bg-[#fff2f2] dark:bg-[#1D0002] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden flex items-center justify-center">
                    <img
                        src="{{ asset('images/ipon-brilian-logo.png') }}"
                        alt="Logo Ipon Brilian"
                        class="w-40 h-auto lg:w-52"
                    />
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
