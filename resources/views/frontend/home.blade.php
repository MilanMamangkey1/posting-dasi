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

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 transition-all duration-300 shadow-sm">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <x-app-logos size="w-9 h-9 lg:w-11 lg:h-11" secondary-size="w-9 h-9 lg:w-11 lg:h-11" gap-class="gap-2" placeholder />
                    <div class="flex flex-col">
                        <span class="text-lg lg:text-xl font-bold text-slate-900">
                            <span class="text-red-600">Posting</span>
                            <span class="text-blue-600">Dasi</span>
                        </span>
                        <span class="text-xs text-slate-500 -mt-1">Pojok Stunting Digital Terintegrasi</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#education-section" class="text-slate-700 hover:text-red-600 font-medium transition-colors duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        Edukasi
                    </a>
                    <a href="#consultation-section" class="text-slate-700 hover:text-red-600 font-medium transition-colors duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                        Konsultasi
                    </a>
                    
                </div>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-700 hover:text-red-600 hover:bg-slate-100 transition-colors duration-200"
                        id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-white border-t border-slate-200 shadow-lg" id="mobile-menu">
            <div class="px-6 py-4 space-y-4">
                <a href="#education-section" class="flex items-center gap-2 text-slate-700 hover:text-red-600 font-medium py-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                    </svg>
                    Edukasi
                </a>
                <a href="#consultation-section" class="flex items-center gap-2 text-slate-700 hover:text-red-600 font-medium py-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                    </svg>
                    Konsultasi
                </a>

            </div>
        </div>
    </nav>

   <!-- Hero Section -->
    <section class="bg-gradient-to-br from-red-50 via-white to-rose-50 border-b border-slate-200 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
            <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-red-200"></div>
            <div class="absolute top-1/3 -left-12 w-32 h-32 rounded-full bg-amber-200"></div>
            <div class="absolute bottom-0 right-1/4 w-48 h-48 rounded-full bg-green-200"></div>
        </div>
        
        <div class="mx-auto max-w-6xl px-6 py-16 relative z-10">
            <div class="text-center">
                <div class="inline-flex items-center gap-3 rounded-2xl bg-white/80 backdrop-blur-sm border border-slate-200 px-6 py-3 shadow-sm mb-8"></div>
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                    <span class="inline-block text-red-600">Posting</span>
                    <span class="inline-block text-blue-600">Dasi</span>
                </h1>
                <p class="mt-3 text-lg sm:text-xl text-slate-600">(Pojok Stunting Digital Terintegrasi)</p>
                <p class="mx-auto mt-6 max-w-2xl text-xl text-slate-600 leading-relaxed">
                    Jelajahi berbagai konten edukasi berkualitas dan dapatkan konsultasi profesional 
                    untuk pencegahan stunting di Kota Tomohon.
                </p>
                <div class="mt-10 flex items-center justify-center gap-4 flex-wrap">
                    <a href="#education-section" class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-red-200 transition-all duration-200 hover:bg-red-700 hover:shadow-xl hover:shadow-red-300 hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        Jelajahi Konten
                    </a>
                    <a href="#consultation-section" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-8 py-4 text-lg font-semibold text-slate-700 shadow-lg shadow-slate-200 transition-all duration-200 hover:bg-slate-50 hover:shadow-xl hover:shadow-slate-300 hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                        Konsultasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-6 py-16">
        <!-- Education Content Section -->
        <section id="education-section" class="mb-20">
            <div class="text-center mb-12">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 text-white shadow-lg mb-4 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">Konten Edukasi</h2>
                <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">
                    Temukan berbagai materi pembelajaran dalam format yang beragam.
                </p>
            </div>

            @if ($videos->isEmpty() && $photos->isEmpty() && $narratives->isEmpty() && $materials->isEmpty())
                <div class="text-center py-16">
                    <div class="inline-flex h-24 w-24 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum ada konten tersedia</h3>
                    <p class="text-slate-600">Konten edukasi akan segera hadir untuk Anda.</p>
                </div>
            @else
                <!-- Videos Section -->
                @if ($videos->isNotEmpty())
                    <div class="mb-16 rounded-3xl bg-gradient-to-br from-purple-50 to-purple-100 p-8 shadow-lg">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-900">Video Edukasi</h3>
                                <p class="text-slate-600">Belajar melalui konten video yang informatif</p>
                            </div>
                        </div>
                        <div class="grid gap-8 lg:grid-cols-2">
                            @foreach ($videos as $video)
                                <article class="group rounded-2xl border border-purple-200 bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                    <div class="flex items-start gap-4">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-xl font-semibold text-slate-900 group-hover:text-purple-600 transition-colors duration-200">{{ $video->title }}</h4>
                                            @if ($video->summary)
                                                <p class="mt-3 text-slate-600 leading-relaxed">{{ $video->summary }}</p>
                                            @endif
                                            @if ($video->embed_url)
                                                <div class="mt-4 aspect-video w-full overflow-hidden rounded-xl border border-purple-200 bg-slate-900 shadow-lg">
                                                    <iframe src="{{ $video->embed_url }}" title="Video YouTube" frameborder="0" allowfullscreen class="h-full w-full transition-transform duration-300 group-hover:scale-105"></iframe>
                                                </div>
                                            @elseif($video->source_url)
                                                <div class="mt-4">
                                                    <a href="{{ $video->source_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-purple-100 px-4 py-3 text-purple-700 hover:bg-purple-200 transition-all">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                        </svg>
                                                        Tonton Video
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Paginasi Video -->
                        @if ($videos->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $videos->appends(request()->except('video_page'))->onEachSide(1)->links('components.pagination') }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Photos Section -->
                @if ($photos->isNotEmpty())
                    <div class="mb-16 rounded-3xl bg-gradient-to-br from-blue-50 to-blue-100 p-8 shadow-lg">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-900">Galeri Foto</h3>
                                <p class="text-slate-600">Visualisasi pembelajaran melalui gambar</p>
                            </div>
                        </div>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($photos as $photo)
                                <article class="group rounded-2xl border border-blue-200 bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-slate-900">{{ $photo->title }}</h4>
                                    </div>
                                    @if ($photo->summary)
                                        <p class="text-slate-600 text-sm mb-4">{{ $photo->summary }}</p>
                                    @endif
                                    @if ($photo->photo_url)
                                        @php
                                            $dimensions = $photo->photo_dimensions;
                                            $aspectRatio = $dimensions['aspect_ratio_css'] ?? null;
                                            $orientation = $dimensions['orientation'] ?? null;
                                            $heightLimitClass = match ($orientation) {
                                                'portrait' => 'max-h-80',
                                                default => 'max-h-64',
                                            };
                                            $aspectFallbackClass = $aspectRatio ? '' : 'aspect-[4/3]';
                                        @endphp
                                        <button type="button" class="group/btn w-full text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 rounded-xl overflow-hidden"
                                            data-photo-preview
                                            data-photo-src="{{ $photo->photo_url }}"
                                            data-photo-alt="{{ $photo->title }}"
                                            data-photo-title="{{ $photo->title }}"
                                            @if ($photo->summary) data-photo-summary="{{ $photo->summary }}" @endif
                                        >
                                            <div class="relative overflow-hidden rounded-xl bg-slate-100 {{ $heightLimitClass }} {{ $aspectFallbackClass }}"
                                                @if ($aspectRatio) style="aspect-ratio: {{ $aspectRatio }};" @endif
                                            >
                                                <img src="{{ $photo->photo_url }}" alt="{{ $photo->title }}" class="h-full w-full object-cover transition-all duration-500 group-hover/btn:scale-110" loading="lazy">
                                                <div class="absolute inset-0 bg-black/0 transition-all duration-300 group-hover/btn:bg-black/10"></div>
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-all duration-300 group-hover/btn:opacity-100">
                                                    <div class="rounded-full bg-white/90 p-3 shadow-lg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    @endif
                                </article>
                            @endforeach
                        </div>

                        @if ($photos->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $photos->appends(request()->except('photo_page'))->onEachSide(1)->links('components.pagination') }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Narratives Section -->
                @if ($narratives->isNotEmpty())
                    <div class="mb-16 rounded-3xl bg-gradient-to-br from-green-50 to-green-100 p-8 shadow-lg">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-900">Narasi Edukasi</h3>
                                <p class="text-slate-600">Pembelajaran melalui cerita dan penjelasan tertulis</p>
                            </div>
                        </div>
                        <div class="grid gap-6">
                            @foreach ($narratives as $narrative)
                                <article class="group rounded-2xl border border-green-200 bg-white p-8 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                    <div class="flex items-start gap-6">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-xl font-semibold text-slate-900 group-hover:text-green-600 transition-colors duration-200">{{ $narrative->title }}</h4>
                                            @if ($narrative->summary)
                                                <p class="mt-3 text-slate-600 leading-relaxed">{{ $narrative->summary }}</p>
                                            @endif
                                            @if ($narrative->body)
                                                @php
                                                    $narrativeBody = (string) $narrative->body;
                                                    $narrativePreviewLimit = 100;
                                                    $narrativeBodyLength = \Illuminate\Support\Str::length($narrativeBody);
                                                    $narrativeShouldTruncate = $narrativeBodyLength > $narrativePreviewLimit;
                                                    $narrativePreview = $narrativeShouldTruncate
                                                        ? \Illuminate\Support\Str::substr($narrativeBody, 0, $narrativePreviewLimit)
                                                        : $narrativeBody;
                                                    $narrativeRemainder = $narrativeShouldTruncate
                                                        ? \Illuminate\Support\Str::substr($narrativeBody, $narrativePreviewLimit)
                                                        : '';
                                                    $narrativeContentId = 'narrative-body-' . $loop->index;
                                                @endphp
                                                <div class="mt-4 p-4 bg-green-50 rounded-xl border border-green-200" data-narrative-container>
                                                    <p id="{{ $narrativeContentId }}" class="whitespace-pre-line text-slate-700 leading-relaxed">
                                                        <span data-narrative-preview>{{ $narrativePreview }}</span>
                                                        @if ($narrativeShouldTruncate)
                                                            <span data-narrative-dots>...</span>
                                                            <span class="hidden" data-narrative-remaining>{{ $narrativeRemainder }}</span>
                                                        @endif
                                                    </p>
                                                    @if ($narrativeShouldTruncate)
                                                        <button type="button"
                                                            class="mt-3 inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-green-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500"
                                                            data-narrative-toggle
                                                            data-target="{{ $narrativeContentId }}"
                                                            aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span data-narrative-toggle-text>Lihat selengkapnya</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @if ($narratives->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $narratives->appends(request()->except('narrative_page'))->onEachSide(1)->links('components.pagination') }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Materials Section -->
                @if ($materials->isNotEmpty())
                    <div class="mb-16 rounded-3xl bg-gradient-to-br from-amber-50 to-amber-100 p-8 shadow-lg">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-900">Materi Edukasi</h3>
                                <p class="text-slate-600">Dokumen dan materi pembelajaran yang dapat diunduh</p>
                            </div>
                        </div>
                        <div class="grid gap-6 lg:grid-cols-2">
                            @foreach ($materials as $material)
                                <article class="group rounded-2xl border border-amber-200 bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                    <div class="flex items-start gap-4">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-semibold text-slate-900 group-hover:text-amber-600 transition-colors duration-200">{{ $material->title }}</h4>
                                            @if ($material->summary)
                                                <p class="mt-2 text-slate-600 text-sm">{{ $material->summary }}</p>
                                            @endif
                                            @php
                                                $materialSize = $formatFileSize($material->document_size_bytes);
                                                $materialExtension = $material->document_extension ? strtoupper($material->document_extension) : null;
                                            @endphp
                                            @if ($material->document_url)
                                                <div class="mt-4 flex items-center justify-between rounded-xl border border-amber-200 bg-white p-4 transition-all duration-200 group-hover:border-amber-300 group-hover:bg-amber-50">
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-slate-900">{{ $materialExtension ? 'File ' . $materialExtension : 'Dokumen' }}</p>
                                                            @if ($materialSize)
                                                                <p class="text-sm text-slate-500">Ukuran: {{ $materialSize }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="{{ $material->document_url }}" target="_blank" rel="noopener"
                                                       class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-amber-700 hover:shadow-lg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Unduh
                                                    </a>
                                                </div>
                                            @elseif ($material->body)
                                                <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
                                                    <p class="whitespace-pre-line text-slate-700 text-sm leading-relaxed">{{ $material->body }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @if ($materials->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $materials->appends(request()->except('material_page'))->onEachSide(1)->links('components.pagination') }}
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </section>

        <!-- Consultation Section -->
        <section id="consultation-section" class="rounded-3xl bg-gradient-to-br from-slate-900 to-slate-800 p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/10 rounded-full -translate-y-32 translate-x-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-500/10 rounded-full -translate-x-24 translate-y-24"></div>
            
            <div class="relative z-10">
                <div class="text-center mb-10">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 text-white shadow-lg mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white sm:text-4xl">Konsultasi Gratis</h2>
                    <p class="mt-4 text-lg text-slate-300 max-w-2xl mx-auto">
                        Dapatkan bimbingan profesional dari tim ahli kami untuk pencegahan stunting.
                    </p>
                </div>

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
                    <div class="mb-6 rounded-2xl border border-red-400 bg-red-50 p-6 text-red-700">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-semibold">Perhatian</p>
                                <p class="text-sm mt-1">Silakan periksa kembali formulir Anda.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('public.consultations.store') }}" class="space-y-6">
                    @csrf
                    @php($recaptchaKey = config('services.recaptcha.key'))

                    <div class="grid gap-6 lg:grid-cols-2">
                        <div class="space-y-6">
                            <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white">Data Pribadi</h3>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-slate-200 mb-2">Nama Lengkap</label>
                                        <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" required placeholder="Masukkan nama lengkap"
                                               class="w-full rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-white placeholder-slate-300 backdrop-blur-sm transition-all duration-200 focus:border-white/40 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30">
                                        @error('full_name') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="whatsapp_number" class="block text-sm font-medium text-slate-200 mb-2">Nomor WhatsApp</label>
                                        <input id="whatsapp_number" name="whatsapp_number" type="tel" value="{{ old('whatsapp_number') }}" required placeholder="+6281234567890"
                                               class="w-full rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-white placeholder-slate-300 backdrop-blur-sm transition-all duration-200 focus:border-white/40 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30">
                                        @error('whatsapp_number') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                                        <p class="mt-1 text-xs text-slate-300">Gunakan format internasional</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white">Alamat & Permasalahan</h3>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-slate-200 mb-2">Alamat Lengkap</label>
                                        <textarea id="address" name="address" rows="3" required placeholder="Tuliskan alamat lengkap"
                                                  class="w-full rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-white placeholder-slate-300 backdrop-blur-sm transition-all duration-200 focus:border-white/40 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30"
                                                  data-auto-resize>{{ old('address') }}</textarea>
                                        @error('address') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="issue_description" class="block text-sm font-medium text-slate-200 mb-2">Deskripsi Permasalahan</label>
                                        <textarea id="issue_description" name="issue_description" rows="4" required placeholder="Sampaikan keluhan Anda"
                                                  class="w-full rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-white placeholder-slate-300 backdrop-blur-sm transition-all duration-200 focus:border-white/40 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30"
                                                  data-auto-resize>{{ old('issue_description') }}</textarea>
                                        @error('issue_description') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Verifikasi & Pengajuan</h3>
                        </div>

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex-1">
                                    @if (app()->bound('captcha'))
                                        {!! app('captcha')->display() !!}
                                    @endif
                                    @error('g-recaptcha-response') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                                </div>

                            <button type="submit"
                                    class="inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-red-500/25 transition-all duration-200 hover:from-red-700 hover:to-rose-700 hover:shadow-xl hover:shadow-red-500/40 hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Kirim Pengajuan Konsultasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Photo Preview Modal -->
    <div id="photo-preview-overlay" class="fixed inset-0 z-50 hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-slate-900/95 backdrop-blur-sm" data-photo-preview-dismiss></div>
        <div class="relative z-10 flex h-full w-full items-center justify-center p-4">
            <div class="relative w-full max-w-6xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                <button type="button" class="absolute right-4 top-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-700 shadow-lg transition-all duration-200 hover:bg-slate-100 hover:text-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-600"
                        data-photo-preview-close aria-label="Tutup pratinjau foto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="max-h-[80vh] w-full overflow-auto bg-slate-950">
                    <img data-photo-preview-image src="" alt="" class="mx-auto block h-full max-h-[80vh] w-full object-contain">
                </div>
                <div class="space-y-3 border-t border-slate-200 bg-white px-6 py-5">
                    <p data-photo-preview-title class="text-xl font-bold text-slate-900"></p>
                    <p data-photo-preview-summary class="text-slate-600 leading-relaxed"></p>
                </div>
            </div>
        </div>
    </div>
        @if (app()->bound('captcha'))
            {!! app('captcha')->renderJs() !!}
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Auto-resize textareas
                document.querySelectorAll('[data-auto-resize]').forEach(textarea => {
                    const resize = () => {
                        textarea.style.height = 'auto';
                        textarea.style.height = textarea.scrollHeight + 'px';
                    };
                    textarea.addEventListener('input', resize);
                    resize();
                });

                // Smooth scroll
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                });

                // Narrative expand/collapse
                document.querySelectorAll('[data-narrative-toggle]').forEach(button => {
                    button.addEventListener('click', function () {
                        const targetId = this.getAttribute('data-target');
                        if (!targetId) {
                            return;
                        }

                        const content = document.getElementById(targetId);
                        if (!content) {
                            return;
                        }

                        const remaining = content.querySelector('[data-narrative-remaining]');
                        const dots = content.querySelector('[data-narrative-dots]');
                        const label = this.querySelector('[data-narrative-toggle-text]');
                        const icon = this.querySelector('svg');

                        const nextExpanded = this.getAttribute('aria-expanded') !== 'true';
                        this.setAttribute('aria-expanded', nextExpanded ? 'true' : 'false');

                        if (remaining) {
                            remaining.classList.toggle('hidden', !nextExpanded);
                        }

                        if (dots) {
                            dots.classList.toggle('hidden', nextExpanded);
                        }

                        if (label) {
                            label.textContent = nextExpanded ? 'Sembunyikan' : 'Lihat selengkapnya';
                        }

                        if (icon) {
                            icon.classList.toggle('rotate-180', nextExpanded);
                        }
                    });
                });
            });
        </script>

        <!-- Photo Preview -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const overlay = document.getElementById('photo-preview-overlay');
                if (!overlay) return;

                const imageEl = overlay.querySelector('[data-photo-preview-image]');
                const titleEl = overlay.querySelector('[data-photo-preview-title]');
                const summaryEl = overlay.querySelector('[data-photo-preview-summary]');
                const closeButton = overlay.querySelector('[data-photo-preview-close]');
                let lastFocusedElement = null;

                const openOverlay = (dataset) => {
                    lastFocusedElement = document.activeElement;
                    const src = dataset.photoSrc;
                    if (!src) return;

                    imageEl.src = src;
                    imageEl.alt = dataset.photoAlt || dataset.photoTitle || '';
                    titleEl.textContent = dataset.photoTitle || '';
                    const summary = dataset.photoSummary || '';
                    summaryEl.textContent = summary;
                    summaryEl.classList.toggle('hidden', summary.trim() === '');

                    overlay.classList.remove('hidden');
                    overlay.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                    closeButton?.focus({ preventScroll: true });
                };

                const closeOverlay = () => {
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

                document.querySelectorAll('[data-photo-preview]').forEach(trigger => {
                    trigger.addEventListener('click', () => openOverlay(trigger.dataset));
                });

                overlay.addEventListener('click', e => {
                    if (e.target === overlay || e.target.hasAttribute('data-photo-preview-dismiss')) {
                        closeOverlay();
                    }
                });

                closeButton?.addEventListener('click', closeOverlay);

                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                        e.preventDefault();
                        closeOverlay();
                    }
                });
            });

            // Mobile Menu
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    mobileMenu.classList.toggle('hidden', !isHidden);
                    mobileMenuButton.innerHTML = isHidden
                        ? `<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`
                        : `<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>`;
                });

                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.innerHTML = `<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>`;
                    });
                });
            }
        </script>
    @endpush
@endsection
