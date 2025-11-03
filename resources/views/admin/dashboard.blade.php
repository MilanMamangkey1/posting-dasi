@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('body')
    <header class="bg-white border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-semibold text-slate-900">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 3h5.25v5.25H4.5V3zm9.75 0H19.5v5.25h-5.25V3zm0 9.75H19.5V18h-5.25v-5.25zM4.5 12.75H9.75V18H4.5v-5.25z" />
                        </svg>
                    </span>
                    Website Posting Dasi &mdash; Dasbor Admin
                </h1>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row lg:items-start lg:gap-10">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

        <main class="flex-1 space-y-12">
            @if ($statusMessage)
                @push('scripts')
                    <script>
                        const toastSuccessPayload = { type: 'success', message: @json($statusMessage) };
                        if (typeof window.enqueueToast === 'function') {
                            window.enqueueToast(toastSuccessPayload);
                        } else {
                            window.__toastQueue = window.__toastQueue || [];
                            window.__toastQueue.push(toastSuccessPayload);
                        }
                    </script>
                @endpush
            @endif

            @if ($statusError)
                @push('scripts')
                    <script>
                        const toastErrorPayload = { type: 'error', message: @json($statusError) };
                        if (typeof window.enqueueToast === 'function') {
                            window.enqueueToast(toastErrorPayload);
                        } else {
                            window.__toastQueue = window.__toastQueue || [];
                            window.__toastQueue.push(toastErrorPayload);
                        }
                    </script>
                @endpush
            @endif

            <section id="metrics" class="space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-900">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19.5h18M7.5 15V9.75M12 15V6M16.5 15V12" />
                                </svg>
                            </span>
                            Ringkasan Data
                        </h2>
                        <p class="text-sm text-slate-600">Pantau metrik inti Posting Dasi.</p>
                    </div>
                    <div class="text-xs uppercase text-red-600">
                        Terakhir diperbarui {{ now()->translatedFormat('d M Y, H:i') }}
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <article class="metric-card">
                        <div class="metric-card__body">
                            <dt>Total Konten</dt>
                            <dd>{{ $metrics['total_contents'] }}</dd>
                        </div>
                        <p class="metric-card__hint">Akumulasi konten edukasi terdaftar.</p>
                    </article>
                    <article class="metric-card">
                        <div class="metric-card__body">
                            <dt>Total Konsultasi</dt>
                            <dd>{{ $metrics['total_consultations'] }}</dd>
                        </div>
                        <p class="metric-card__hint">Jumlah permintaan konsultasi yang masuk.</p>
                    </article>
                    <article class="metric-card sm:col-span-2">
                        <div class="metric-card__body">
                            <dt>Konten per Jenis</dt>
                            <dd class="text-base font-semibold text-slate-900">
                                @foreach ($metrics['contents_by_type'] as $type => $total)
                                    <span class="mr-3 uppercase text-xs text-red-600">{{ $contentTypeLabels[$type] ?? ucfirst($type) }}</span>
                                    <span class="mr-4 text-sm text-slate-900">{{ $total }}</span>
                                @endforeach
                            </dd>
                        </div>
                        <p class="metric-card__hint">Distribusi video, foto, narasi, dan materi.</p>
                    </article>
                    <article class="metric-card sm:col-span-2 lg:col-span-4">
                        <div class="metric-card__body">
                            <dt>Status Konsultasi</dt>
                            <dd class="text-base font-semibold text-slate-900">
                                @foreach ($metrics['consultations_by_status'] as $status => $total)
                                    <span class="mr-3 uppercase text-xs text-red-600">{{ $consultationStatusLabels[$status] ?? str_replace('_', ' ', $status) }}</span>
                                    <span class="mr-4 text-sm text-slate-900">{{ $total }}</span>
                                @endforeach
                            </dd>
                        </div>
                        <p class="metric-card__hint">Gunakan untuk memantau antrian layanan.</p>
                    </article>
                </div>
            </section>

            <section class="space-y-6">
                <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-900">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l3 1.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    Aktivitas Terbaru
                </h2>
                <div class="grid gap-6 lg:grid-cols-2">
                    <section class="panel">
                        <header class="panel__header">
                            <h3 class="flex items-center gap-2">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 4.5h9.75a1.5 1.5 0 011.5 1.5V21l-6-3-6 3V6a1.5 1.5 0 011.5-1.5z" />
                                    </svg>
                                </span>
                                Konten Terbaru
                            </h3>
                        </header>
                        <ul class="space-y-3 text-sm text-slate-700">
                            @forelse ($recentContents as $content)
                                <li class="rounded-lg border border-slate-200 px-3 py-2">
                                    <span class="font-semibold text-slate-900">{{ $content->title }}</span>
                                    <span class="ml-2 uppercase text-xs text-red-600">({{ $contentTypeLabels[$content->type] ?? ucfirst($content->type) }})</span>
                                    <span class="ml-3 text-xs text-slate-500">Diperbarui {{ $content->updated_at->diffForHumans() }}</span>
                                    @if ($content->photo_url)
                                        <a
                                            href="{{ $content->photo_url }}"
                                            target="_blank"
                                            rel="noopener"
                                        class="mt-3 block overflow-hidden rounded-md border border-slate-200 bg-white"
                                        >
                                            <img
                                                src="{{ $content->photo_url }}"
                                                alt="Pratinjau foto {{ $content->title }}"
                                                class="h-32 w-full object-cover transition duration-200 hover:scale-[1.02]"
                                                loading="lazy"
                                            >
                                        </a>
                                    @elseif ($content->document_url)
                                        <a
                                            href="{{ $content->document_url }}"
                                            target="_blank"
                                            rel="noopener"
                                        class="mt-3 inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 hover:text-red-600"
                                        >
                                            <span>Unduh {{ strtoupper($content->document_extension ?? 'Berkas') }}</span>
                                            @if ($content->document_size_bytes)
                                                @php
                                                    $recentDocBytes = $content->document_size_bytes;
                                                    $recentUnits = ['B', 'KB', 'MB', 'GB', 'TB'];
                                                    $recentSize = (float) $recentDocBytes;
                                                    $recentIndex = 0;
                                                    while ($recentSize >= 1024 && $recentIndex < count($recentUnits) - 1) {
                                                        $recentSize /= 1024;
                                                        $recentIndex++;
                                                    }
                                                    $recentPrecision = $recentIndex === 0 ? 0 : 1;
                                                    $recentFormatted = number_format($recentSize, $recentPrecision);
                                                    $recentFormatted = rtrim(rtrim($recentFormatted, '0'), '.');
                                                    $recentDocLabel = $recentFormatted . ' ' . $recentUnits[$recentIndex];
                                                @endphp
                                                <span class="text-red-600">({{ $recentDocLabel }})</span>
                                            @endif
                                        </a>
                                    @endif
                                </li>
                            @empty
                                <li class="text-red-600">Belum ada konten.</li>
                            @endforelse
                        </ul>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.contents.index') }}" class="accent-link">Kelola Konten &rarr;</a>
                        </div>
                    </section>
                    <section class="panel">
                        <header class="panel__header">
                            <h3 class="flex items-center gap-2">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 9h7.5m-7.5 3h4.5m-10.5 0a8.25 8.25 0 0114.768-4.5A7.5 7.5 0 0122.5 15.75c0 1.268-.309 2.463-.855 3.513a.75.75 0 01-.984.351l-3.09-1.375a2.25 2.25 0 00-1.876.042 7.46 7.46 0 01-3.195.719 7.5 7.5 0 01-7.5-7.5z" />
                                    </svg>
                                </span>
                                Konsultasi Terbaru
                            </h3>
                        </header>
                        <ul class="space-y-3 text-sm text-slate-700">
                            @forelse ($recentConsultations as $consultation)
                                <li class="rounded-lg border border-slate-200 px-3 py-2">
                                    <span class="font-semibold text-slate-900">{{ $consultation->full_name }}</span>
                                    <span class="ml-2 uppercase text-xs text-red-600">({{ $consultationStatusLabels[$consultation->status] ?? str_replace('_', ' ', $consultation->status) }})</span>
                                    <span class="ml-3 text-xs text-slate-500">Diperbarui {{ $consultation->updated_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="text-red-600">Belum ada pengajuan.</li>
                            @endforelse
                        </ul>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.consultations.index') }}" class="accent-link">Kelola Konsultasi &rarr;</a>
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>
@endsection
