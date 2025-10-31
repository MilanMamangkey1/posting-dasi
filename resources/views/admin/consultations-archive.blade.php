@extends('layouts.admin')

@section('title', 'Arsip Pengajuan Konsultasi')

@section('body')
    <header class="bg-white border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-semibold text-slate-900">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 4.5h15l-.75 3.75H5.25L4.5 4.5zm1.5 3.75v9a1.5 1.5 0 001.5 1.5h9a1.5 1.5 0 001.5-1.5v-9" />
                        </svg>
                    </span>
                    Arsip Pengajuan Konsultasi
                </h1>
                <p class="text-sm text-slate-600">Daftar permintaan konsultasi yang sudah terselesaikan.</p>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row lg:items-start lg:gap-10">
        @include('admin.partials.sidebar', ['active' => 'consultations_archive'])

        <main class="flex-1 space-y-8">
            <section class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-900">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.25 6h13.5v12.75a1.5 1.5 0 01-1.5 1.5H6.75a1.5 1.5 0 01-1.5-1.5V6z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6a1.5 1.5 0 011.5 1.5V6H7.5V4.5A1.5 1.5 0 019 3z" />
                                </svg>
                            </span>
                            Arsip Konsultasi
                        </h2>
                        <p class="text-sm text-slate-600">Cari berdasarkan nama atau nomor WhatsApp.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.consultations.archive') }}" class="flex flex-wrap items-end gap-3 text-sm text-slate-700">
                        <div class="flex flex-col">
                            <label for="archive_search" class="text-xs uppercase text-red-600">Kata kunci</label>
                            <input id="archive_search" type="search" name="archive_search" value="{{ $filters['search'] }}" class="form-input w-64" placeholder="Cari arsip">
                        </div>
                        <button type="submit" class="secondary-button">Cari</button>
                    </form>
                </div>

                <section class="panel">
                    <header class="panel__header">
                        <h3 class="flex items-center gap-2">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 7.5h9m-9 3h9m-9 3h4.5M5.25 4.5h13.5a1.5 1.5 0 011.5 1.5v12a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-12a1.5 1.5 0 011.5-1.5z" />
                                </svg>
                            </span>
                            Riwayat Arsip
                        </h3>
                    </header>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-700">
                            <thead class="border-b border-slate-200 text-xs font-semibold uppercase text-red-600">
                                <tr>
                                    <th class="px-4 py-3">Pemohon</th>
                                    <th class="px-4 py-3">Kontak</th>
                                    <th class="px-4 py-3">Ditangani Oleh</th>
                                    <th class="px-4 py-3">Diarsipkan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse ($archives as $archive)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-slate-900">{{ $archive->full_name }}</div>
                                            <p class="mt-1 text-xs text-slate-500 whitespace-pre-line">{{ $archive->issue_description }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div>{{ $archive->whatsapp_number }}</div>
                                            @if ($archive->admin_notes)
                                                <p class="mt-1 text-xs text-slate-500">Catatan: {{ $archive->admin_notes }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-600">
                                                {{ optional($archive->handler)->name ?? '-' }}
                                            </div>
                                            <p class="text-xs text-slate-500">
                                                Ditangani {{ optional($archive->handled_at)->diffForHumans() ?? '-' }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-600">{{ optional($archive->archived_at)->translatedFormat('d M Y, H:i') ?? '-' }}</div>
                                            <p class="text-xs text-red-600">Status: {{ $consultationStatusLabels[$archive->status] ?? ucfirst($archive->status) }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-5 text-center text-sm text-red-600" colspan="4">
                                            Belum ada arsip konsultasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($archives instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">{{ $archives->links() }}</div>
                    @endif
                </section>
            </section>
        </main>
    </div>
@endsection

