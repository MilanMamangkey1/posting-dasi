@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('body')
    <header class="bg-white/90 border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Website Posting Dasi &mdash; Backend Admin</h1>
                <p class="text-sm text-slate-500">
                    Dashboard sederhana tanpa ketergantungan JavaScript berlebih.
                </p>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

        <main class="flex-1 space-y-12">
            @if ($statusMessage)
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ $statusMessage }}
                </div>
            @endif

            @if ($statusError)
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $statusError }}
                </div>
            @endif

            <section id="metrics" class="space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Ringkasan Data</h2>
                        <p class="text-sm text-slate-500">Pantau metrik inti Posting Dasi.</p>
                    </div>
                    <div class="text-xs uppercase text-slate-400">
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
                                    <span class="mr-3 uppercase text-xs text-slate-500">{{ $type }}</span>
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
                                    <span class="mr-3 uppercase text-xs text-slate-500">{{ str_replace('_', ' ', $status) }}</span>
                                    <span class="mr-4 text-sm text-slate-900">{{ $total }}</span>
                                @endforeach
                            </dd>
                        </div>
                        <p class="metric-card__hint">Gunakan untuk memantau antrian layanan.</p>
                    </article>
                </div>
            </section>

            <section class="space-y-6">
                <h2 class="text-xl font-semibold text-slate-900">Aktivitas Terbaru</h2>
                <div class="grid gap-6 lg:grid-cols-2">
                    <section class="panel">
                        <header class="panel__header">
                            <h3>Konten Terbaru</h3>
                        </header>
                        <ul class="space-y-3 text-sm text-slate-600">
                            @forelse ($recentContents as $content)
                                <li class="rounded-lg border border-slate-200 px-3 py-2">
                                    <span class="font-semibold text-slate-800">{{ $content->title }}</span>
                                    <span class="ml-2 uppercase text-xs text-slate-500">({{ $content->type }})</span>
                                    <span class="ml-3 text-xs text-slate-400">Diperbarui {{ $content->updated_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="text-slate-500">Belum ada konten.</li>
                            @endforelse
                        </ul>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.contents.index') }}" class="text-sm font-semibold text-slate-900 hover:underline">Kelola Konten &rarr;</a>
                        </div>
                    </section>
                    <section class="panel">
                        <header class="panel__header">
                            <h3>Konsultasi Terbaru</h3>
                        </header>
                        <ul class="space-y-3 text-sm text-slate-600">
                            @forelse ($recentConsultations as $consultation)
                                <li class="rounded-lg border border-slate-200 px-3 py-2">
                                    <span class="font-semibold text-slate-800">{{ $consultation->full_name }}</span>
                                    <span class="ml-2 uppercase text-xs text-slate-500">({{ str_replace('_', ' ', $consultation->status) }})</span>
                                    <span class="ml-3 text-xs text-slate-400">Diperbarui {{ $consultation->updated_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="text-slate-500">Belum ada pengajuan.</li>
                            @endforelse
                        </ul>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.consultations.index') }}" class="text-sm font-semibold text-slate-900 hover:underline">Kelola Konsultasi &rarr;</a>
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>
@endsection
