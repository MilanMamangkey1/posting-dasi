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
                <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ $submissionStatus }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-red-600 bg-white px-4 py-3 text-sm text-red-600">
                    Silakan periksa kembali formulir Anda.
                </div>
            @endif

            <form method="POST" action="{{ route('public.consultations.store') }}" class="mt-6 space-y-4">
                @csrf
                <div class="flex flex-col gap-2">
                    <label for="full_name" class="text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        value="{{ old('full_name') }}"
                        required
                        class="form-input"
                    >
                </div>
                <div class="flex flex-col gap-2">
                    <label for="address" class="text-sm font-medium text-slate-700">Alamat</label>
                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        required
                        class="form-input"
                    >{{ old('address') }}</textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="issue_description" class="text-sm font-medium text-slate-700">Deskripsi Permasalahan</label>
                    <textarea
                        id="issue_description"
                        name="issue_description"
                        rows="4"
                        required
                        class="form-input"
                    >{{ old('issue_description') }}</textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="whatsapp_number" class="text-sm font-medium text-slate-700">Nomor WhatsApp</label>
                    <input
                        id="whatsapp_number"
                        name="whatsapp_number"
                        type="tel"
                        value="{{ old('whatsapp_number') }}"
                        placeholder="+628xxxxxxxxxx"
                        required
                        class="form-input"
                    >
                    <p class="text-xs text-slate-500">Gunakan format internasional (contoh: +6281234567890).</p>
                </div>
                <button
                    type="submit"
                    class="primary-button inline-flex items-center justify-center gap-2"
                >
                    Kirim Pengajuan
                </button>
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
