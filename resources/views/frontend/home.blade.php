@extends('layouts.public')

@section('title', 'Website Posting Dasi')

@section('body')
    @php
        $formatFileSize = static function (?int $bytes): ?string {
            if ($bytes === null || $bytes <= 0) {
                return null;
            }

            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $size = (float) $bytes;
            $index = 0;

            while ($size >= 1024 && $index < count($units) - 1) {
                $size /= 1024;
                $index++;
            }

            $precision = $index === 0 ? 0 : 1;
            $formatted = number_format($size, $precision);
            $formatted = str_replace('.0', '', $formatted);

            return $formatted . ' ' . $units[$index];
        };
    @endphp
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl flex-col gap-3 px-6 py-8">
            <h1 class="flex items-center gap-3 text-3xl font-semibold text-slate-900">
                <span class="accent-badge h-9 w-9">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v3m6.364-1.364l-2.121 2.121M21 12h-3m1.364 6.364l-2.121-2.121M12 21v-3m-6.364 1.364l2.121-2.121M3 12h3M4.636 5.636l2.121 2.121" />
                    </svg>
                </span>
                Website Posting Dasi
            </h1>
            <p class="text-base text-slate-600">
                Jelajahi konten edukasi dan ajukan konsultasi sesuai kebutuhan Anda. Tampilan ini masih sederhana dan akan terus dikembangkan.
            </p>
        </div>
    </header>

    <main class="mx-auto flex max-w-5xl flex-col gap-12 px-6 py-10">
        <section aria-labelledby="education-section">
            <h2 id="education-section" class="flex items-center gap-3 text-2xl font-semibold text-slate-900">
                <span class="accent-badge h-8 w-8">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 5.25c0-.621.504-1.125 1.125-1.125h5.25A2.625 2.625 0 0112.75 6.75v13.5c0-1.242-1.008-2.25-2.25-2.25h-5.25a1.125 1.125 0 01-1.125-1.125V5.25zM20.25 18.75c0 .621-.504 1.125-1.125 1.125h-5.25A2.625 2.625 0 0111.25 17.25V3.75c0 1.242 1.008 2.25 2.25 2.25h5.25c.621 0 1.125.504 1.125 1.125v11.625z" />
                    </svg>
                </span>
                Konten Edukasi
            </h2>
            <p class="mb-4 text-sm text-slate-600">
                Semua konten yang tersedia: video, foto, narasi, dan materi singkat.
            </p>

            @if ($videos->isEmpty() && $photos->count() === 0 && $narratives->isEmpty() && $materials->isEmpty())
                <p class="text-sm text-red-600">Belum ada konten yang tersedia.</p>
            @else
                @if ($videos->isNotEmpty())
                    <div class="mb-8 space-y-4">
                        <h3 class="flex items-center gap-2 text-xl font-medium text-slate-900">
                            <span class="accent-badge h-7 w-7">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.25 5.653c0-.856.928-1.398 1.665-.948l10.5 6.347a1.125 1.125 0 010 1.896l-10.5 6.347a1.125 1.125 0 01-1.665-.948V5.653z" />
                                </svg>
                            </span>
                            Video
                        </h3>
                        <div class="space-y-6">
                            @foreach ($videos as $video)
                                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $video->title }}</h4>
                                    @if ($video->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $video->summary }}</p>
                                    @endif
                                    @if ($video->embed_url)
                                        <div class="mt-4 aspect-video w-full overflow-hidden rounded-lg border border-slate-200 bg-white">
                                            <iframe
                                                src="{{ $video->embed_url }}"
                                                title="Pemutar video YouTube"
                                                frameborder="0"
                                                allowfullscreen
                                                class="h-full w-full"
                                            ></iframe>
                                        </div>
                                    @elseif($video->source_url)
                                        <p class="mt-4 text-sm text-slate-600">
                                            Tonton di:
                                            <a href="{{ $video->source_url }}" class="text-red-600 underline decoration-red-600 decoration-2 underline-offset-4 hover:text-red-600" target="_blank" rel="noopener">
                                                {{ $video->source_url }}
                                            </a>
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($photos->count() > 0)
                    <div class="mb-8 space-y-4">
                        <h3 class="flex items-center gap-2 text-xl font-medium text-slate-900">
                            <span class="accent-badge h-7 w-7">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 7.5A2.25 2.25 0 014.5 5.25h2.121a2.25 2.25 0 001.591-.659l.828-.828A2.25 2.25 0 0110.632 3h2.736a2.25 2.25 0 011.591.659l.828.828a2.25 2.25 0 001.591.659H19.5A2.25 2.25 0 0121.75 7.5v9a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25v-9z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9.75a3 3 0 110 6 3 3 0 010-6z" />
                                </svg>
                            </span>
                            Foto
                        </h3>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($photos as $photo)
                                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $photo->title }}</h4>
                                    @if ($photo->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $photo->summary }}</p>
                                    @endif
                                    @if ($photo->photo_url)
                                        @php
                                            $dimensions = $photo->photo_dimensions;
                                            $aspectRatio = $dimensions['aspect_ratio_css'] ?? null;
                                            $orientation = $dimensions['orientation'] ?? null;
                                            $heightLimitClass = match ($orientation) {
                                                'portrait' => 'max-h-[32rem]',
                                                default => 'max-h-[24rem]',
                                            };
                                            $aspectFallbackClass = $aspectRatio ? '' : 'aspect-[4/3]';
                                        @endphp
                                        <button
                                            type="button"
                                            class="group mt-4 block w-full text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600"
                                            data-photo-preview
                                            data-photo-src="{{ $photo->photo_url }}"
                                            data-photo-alt="{{ $photo->title }}"
                                            data-photo-title="{{ $photo->title }}"
                                            @if ($photo->summary) data-photo-summary="{{ $photo->summary }}" @endif
                                        >
                                            <div
                                                class="w-full overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition duration-200 group-hover:shadow-md {{ $heightLimitClass }} {{ $aspectFallbackClass }}"
                                                @if ($aspectRatio) style="aspect-ratio: {{ $aspectRatio }};" @endif
                                            >
                                                <img
                                                    src="{{ $photo->photo_url }}"
                                                    alt="{{ $photo->title }}"
                                                    class="h-full w-full object-cover transition duration-200 group-hover:scale-[1.05]"
                                                    loading="lazy"
                                                >
                                            </div>
                                        </button>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                        @if ($photos->hasPages())
                            <div class="mt-6">
                                {{ $photos->appends(request()->except('photo_page'))->onEachSide(1)->links() }}
                            </div>
                        @endif
                    </div>
                @endif

                @if ($narratives->isNotEmpty())
                    <div class="mb-8 space-y-4">
                        <h3 class="flex items-center gap-2 text-xl font-medium text-slate-900">
                            <span class="accent-badge h-7 w-7">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7.5h6m-6 3h6m-6 3h6M9 21h6a2.25 2.25 0 002.25-2.25V7.5L13.5 3H9A2.25 2.25 0 006.75 5.25v13.5A2.25 2.25 0 009 21z" />
                                </svg>
                            </span>
                            Narasi
                        </h3>
                        <div class="space-y-6">
                            @foreach ($narratives as $narrative)
                                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $narrative->title }}</h4>
                                    @if ($narrative->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $narrative->summary }}</p>
                                    @endif
                                    @if ($narrative->body)
                                        <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">
                                            {{ $narrative->body }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($materials->isNotEmpty())
                    <div class="space-y-4">
                        <h3 class="flex items-center gap-2 text-xl font-medium text-slate-900">
                            <span class="accent-badge h-7 w-7">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v1.125A2.625 2.625 0 005.625 20.25h12.75A2.625 2.625 0 0021 17.625V16.5M12 3v12m0 0l3.75-3.75M12 15L8.25 11.25" />
                                </svg>
                            </span>
                            Materi Edukasi
                        </h3>
                        <div class="space-y-6">
                            @foreach ($materials as $material)
                                <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $material->title }}</h4>
                                    @if ($material->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $material->summary }}</p>
                                    @endif
                                    @php
                                        $materialSize = $formatFileSize($material->document_size_bytes);
                                        $materialExtension = $material->document_extension
                                            ? strtoupper($material->document_extension)
                                            : null;
                                    @endphp
                                    @if ($material->document_url)
                                        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3">
                                            <div>
                                                <p class="text-xs uppercase tracking-wide text-red-600">
                                                    {{ $materialExtension ? 'Berkas ' . $materialExtension : 'Berkas Materi' }}
                                                </p>
                                                @if ($materialSize)
                                                    <p class="text-xs text-red-600">Ukuran {{ $materialSize }}</p>
                                                @endif
                                            </div>
                                            <a
                                                href="{{ $material->document_url }}"
                                                target="_blank"
                                                rel="noopener"
                                                class="inline-flex items-center gap-2 primary-button"
                                            >
                                                <span>Unduh Materi</span>
                                            </a>
                                        </div>
                                    @elseif ($material->body)
                                        <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">
                                            {{ $material->body }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </section>

        <section aria-labelledby="consultation-section" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 id="consultation-section" class="flex items-center gap-3 text-2xl font-semibold text-slate-900">
                <span class="accent-badge h-8 w-8">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 8.25h9m-9 3h6M2.25 12a8.25 8.25 0 1115.573 4.032l1.32 3.3a.75.75 0 01-.966.966l-3.3-1.32A8.25 8.25 0 012.25 12z" />
                    </svg>
                </span>
                Ajukan Konsultasi
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                Isi formulir di bawah ini untuk mengajukan konsultasi. Tim kami akan menghubungi Anda melalui WhatsApp.
            </p>

            @if ($submissionStatus)
                @push('scripts')
                    <script>
                        const toastPublicConsultationPayload = { type: 'success', message: @json($submissionStatus) };
                        if (typeof window.enqueueToast === 'function') {
                            window.enqueueToast(toastPublicConsultationPayload);
                        } else {
                            window.__toastQueue = window.__toastQueue || [];
                            window.__toastQueue.push(toastPublicConsultationPayload);
                        }
                    </script>
                @endpush
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-red-600 bg-white px-4 py-3 text-sm text-red-600">
                    Silakan periksa kembali formulir Anda.
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('public.consultations.store') }}"
                class="mt-6"
            >
                @csrf
                @php($recaptchaKey = config('services.recaptcha.key'))
                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <div class="grid gap-3 bg-slate-50 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500 md:grid-cols-5">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12a4 4 0 100-8 4 4 0 000 8zM19.5 20.25a7.5 7.5 0 00-15 0" />
                                </svg>
                            </span>
                            <span>Data Pemohon</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.593 3.322a1 1 0 011.4.163l1.95 2.437a2 2 0 01.09 2.43l-8.359 11.51a2 2 0 01-3.138.146l-4.4-5.145a2 2 0 01.141-2.825l11.316-10.716z" />
                                </svg>
                            </span>
                            <span>Alamat Domisili</span>
                        </div>
                        <div class="flex items-center gap-2 md:col-span-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 4.5h15m-15 15h15M8.25 9h3m-3 3h7.5m-7.5 3h6" />
                                </svg>
                            </span>
                            <span>Detail Permasalahan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75l9 4.5 9-4.5m-18 0a1.5 1.5 0 01.832-1.342l8.25-4.125a1.5 1.5 0 011.336 0l8.25 4.125A1.5 1.5 0 0121.75 6.75v10.5a1.5 1.5 0 01-.832 1.342l-8.25 4.125a1.5 1.5 0 01-1.336 0l-8.25-4.125A1.5 1.5 0 012.25 17.25V6.75z" />
                                </svg>
                            </span>
                            <span>Kontak &amp; Pengajuan</span>
                        </div>
                    </div>
                    <div class="divide-y border-t border-slate-200">
                        <div class="grid gap-6 bg-white px-4 py-6 md:grid-cols-5">
                            <div class="space-y-3 md:col-span-1">
                                <label for="full_name" class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a6.75 6.75 0 0113.5 0" />
                                        </svg>
                                    </span>
                                    <input
                                        id="full_name"
                                        name="full_name"
                                        type="text"
                                        value="{{ old('full_name') }}"
                                        required
                                        placeholder="Masukkan nama lengkap"
                                        class="form-input pl-12"
                                    >
                                </div>
                                @error('full_name')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-slate-500">Tuliskan nama pemohon sesuai identitas.</p>
                            </div>
                            <div class="space-y-3 md:col-span-1">
                                <label for="address" class="text-sm font-semibold text-slate-700">Alamat</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-4 top-4 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21s8.25-4.5 8.25-10.5A8.25 8.25 0 003.75 10.5C3.75 16.5 12 21 12 21z" />
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                    </span>
                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="4"
                                        required
                                        placeholder="Tuliskan alamat lengkap beserta kelurahan/kecamatan"
                                        class="form-input pl-12"
                                    >{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-slate-500">Cantumkan alamat lengkap agar kami mudah memetakan wilayah.</p>
                            </div>
                            <div class="space-y-3 md:col-span-2">
                                <label for="issue_description" class="text-sm font-semibold text-slate-700">Deskripsi Permasalahan</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-4 top-4 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 5.25h10.5M6.75 9.75h10.5M6.75 14.25h6" />
                                        </svg>
                                    </span>
                                    <textarea
                                        id="issue_description"
                                        name="issue_description"
                                        rows="6"
                                        required
                                        placeholder="Sampaikan keluhan atau kebutuhan konsultasi Anda secara ringkas namun jelas"
                                        class="form-input pl-12"
                                    >{{ old('issue_description') }}</textarea>
                                </div>
                                @error('issue_description')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-slate-500">Contoh: kronologi singkat, kondisi terkini, atau dukungan yang diharapkan.</p>
                            </div>
                            <div class="flex flex-col gap-4 md:col-span-1">
                                <div class="space-y-3">
                                    <label for="whatsapp_number" class="text-sm font-semibold text-slate-700">Nomor WhatsApp</label>
                                    <div class="relative">
                                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 12a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0z" />
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75h.008v.008H9.75V9.75zM14.25 9.75h.008v.008h-.008V9.75z" />
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.438 13.5a3.375 3.375 0 005.124 0" />
                                            </svg>
                                        </span>
                                        <input
                                            id="whatsapp_number"
                                            name="whatsapp_number"
                                            type="tel"
                                            value="{{ old('whatsapp_number') }}"
                                            required
                                            placeholder="+6281234567890"
                                            class="form-input pl-12"
                                        >
                                    </div>
                                    @error('whatsapp_number')
                                        <p class="text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-slate-500">Gunakan format internasional (contoh: +6281234567890).</p>
                                </div>
                                <div class="space-y-3">
                                    <span class="text-sm font-semibold text-slate-700">Verifikasi Keamanan</span>
                                    @if ($recaptchaKey)
                                        <div class="g-recaptcha" data-sitekey="{{ $recaptchaKey }}"></div>
                                        <p class="text-xs text-slate-500">Centang kotak di atas sebelum mengirimkan pengajuan.</p>
                                        @error('g-recaptcha-response')
                                            <p class="text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    @else
                                    <p class="text-xs text-slate-500">recaptcha di sini.</p>
                                    @endif
                                </div>
                                <button
                                    type="submit"
                                    class="primary-button inline-flex w-full items-center justify-center gap-2"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12h15m0 0l-4.5-4.5M19.5 12l-4.5 4.5" />
                                    </svg>
                                    Kirim Pengajuan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <div
        id="photo-preview-overlay"
        class="fixed inset-0 z-50 hidden"
        aria-hidden="true"
    >
        <div class="absolute inset-0 bg-slate-900/80" data-photo-preview-dismiss></div>
        <div class="relative z-10 flex h-full w-full items-center justify-center p-4">
            <div class="relative w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                <button
                    type="button"
                    class="absolute right-3 top-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-red-600 shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600"
                    data-photo-preview-close
                    aria-label="Tutup pratinjau foto"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="max-h-[85vh] w-full overflow-auto bg-slate-950">
                    <img
                        data-photo-preview-image
                        src=""
                        alt=""
                        class="mx-auto block h-full max-h-[85vh] w-full object-contain"
                    >
                </div>
                <div class="space-y-2 border-t border-slate-200 bg-white/95 px-6 py-4">
                    <p
                        data-photo-preview-title
                        class="text-base font-semibold text-slate-900"
                    ></p>
                    <p
                        data-photo-preview-summary
                        class="text-sm text-slate-600"
                    ></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @if (config('services.recaptcha.key'))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overlay = document.getElementById('photo-preview-overlay');
            if (!overlay) {
                return;
            }

            const imageEl = overlay.querySelector('[data-photo-preview-image]');
            const titleEl = overlay.querySelector('[data-photo-preview-title]');
            const summaryEl = overlay.querySelector('[data-photo-preview-summary]');
            const closeButton = overlay.querySelector('[data-photo-preview-close]');
            let lastFocusedElement = null;

            const openOverlay = function (dataset) {
                lastFocusedElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;

                const photoSrc = dataset.photoSrc;
                if (!photoSrc) {
                    return;
                }

                imageEl.src = photoSrc;
                imageEl.alt = dataset.photoAlt || dataset.photoTitle || '';
                titleEl.textContent = dataset.photoTitle || '';

                const summary = dataset.photoSummary || '';
                summaryEl.textContent = summary;
                summaryEl.classList.toggle('hidden', summary.trim() === '');

                overlay.classList.remove('hidden');
                overlay.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');

                if (closeButton) {
                    closeButton.focus({ preventScroll: true });
                }
            };

            const closeOverlay = function () {
                overlay.classList.add('hidden');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');

                imageEl.src = '';
                imageEl.alt = '';
                titleEl.textContent = '';
                summaryEl.textContent = '';

                if (lastFocusedElement) {
                    lastFocusedElement.focus({ preventScroll: true });
                    lastFocusedElement = null;
                }
            };

            document.querySelectorAll('[data-photo-preview]').forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    openOverlay(trigger.dataset);
                });
            });

            overlay.addEventListener('click', function (event) {
                if (event.target === overlay || event.target.hasAttribute('data-photo-preview-dismiss')) {
                    closeOverlay();
                }
            });

            if (closeButton) {
                closeButton.addEventListener('click', closeOverlay);
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !overlay.classList.contains('hidden')) {
                    event.preventDefault();
                    closeOverlay();
                }
            });
        });
    </script>
@endsection
