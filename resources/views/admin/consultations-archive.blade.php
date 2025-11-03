@extends('layouts.admin')

@section('title', 'Arsip Pengajuan Konsultasi')

@section('body')
    <header class="bg-white border-b border-slate-200 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" />
                            <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                        </svg>
                    </span>
                    Arsip Pengajuan Konsultasi
                </h1>
                <p class="mt-1 text-sm text-slate-600">Daftar permintaan konsultasi yang sudah terselesaikan dan terarsipkan.</p>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row lg:items-start lg:gap-10">
        @include('admin.partials.sidebar', ['active' => 'consultations_archive'])

        <main class="flex-1 space-y-8">
            <section class="space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-3 text-xl font-bold text-slate-900">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Arsip Konsultasi
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Gunakan pencarian untuk menemukan arsip konsultasi berdasarkan nama atau nomor WhatsApp.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.consultations.archive') }}" class="flex flex-wrap items-end gap-4 text-sm text-slate-700">
                        <div class="flex flex-col">
                            <label for="archive_search" class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Kata Kunci
                            </label>
                            <input id="archive_search" type="search" name="archive_search" value="{{ $filters['search'] }}" class="form-input w-72 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 transition-colors duration-200" placeholder="Cari berdasarkan nama atau WhatsApp...">
                        </div>
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            Cari Arsip
                        </button>
                    </form>
                </div>

                <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <header class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
                        <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-900">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                </svg>
                            </span>
                            Riwayat Arsip Konsultasi
                        </h3>
                    </header>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-700">
                            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase text-emerald-600">
                                <tr>
                                    <th class="px-6 py-4">Pemohon & Permasalahan</th>
                                    <th class="px-6 py-4">Kontak & Catatan</th>
                                    <th class="px-6 py-4">Penanganan</th>
                                    <th class="px-6 py-4">Status & Arsip</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @php
                                    $decryptArchiveValue = static function (?string $value) {
                                        if ($value === null || $value === '') {
                                            return $value;
                                        }

                                        try {
                                            return \Illuminate\Support\Facades\Crypt::decryptString($value);
                                        } catch (\Illuminate\Contracts\Encryption\DecryptException $exception) {
                                            return $value;
                                        }
                                    };
                                @endphp
                                @forelse ($archives as $archive)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150 group">
                                        <td class="px-6 py-4">
                                            @php
                                                $decryptedWhatsapp = $decryptArchiveValue($archive->getRawOriginal('whatsapp_number'));
                                                $decryptedIssueDescription = $decryptArchiveValue($archive->getRawOriginal('issue_description'));
                                                $decryptedAdminNotes = $decryptArchiveValue($archive->getRawOriginal('admin_notes'));

                                                $sanitizedWhatsapp = preg_replace('/[^0-9]/', '', $decryptedWhatsapp ?? '');
                                                $issueSummary = trim(preg_replace('/\s+/', ' ', $decryptedIssueDescription ?? ''));
                                                $issueSegment = $issueSummary !== '' ? "({$issueSummary})" : '';
                                                $greeting = "Halo, {$archive->full_name} kami dari Dinas PPKBD Kota Tomohon akan memberikan konsultasi terkait dengan keluhan anda";

                                                if ($issueSegment !== '') {
                                                    $greeting .= " {$issueSegment}";
                                                }

                                                $whatsappMessage = $greeting . "\n\n";
                                                $whatsappMessage .= "Jika ada yang ingin ditanyakan lagi jangan sungkan,\n";
                                                $whatsappMessage .= "Hormat Kami Dinas PPKBD kota Tomohon\n\n";
                                                $encodedWhatsappMessage = rawurlencode($whatsappMessage);
                                            @endphp
                                            <div class="flex items-start gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="font-semibold text-slate-900 truncate">{{ $archive->full_name }}</div>
                                                    <p class="mt-1 text-xs text-slate-600 line-clamp-2">{{ $decryptedIssueDescription }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2 text-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                                <span class="font-medium">{{ $decryptedWhatsapp ?? '-' }}</span>
                                            </div>
                                            @if ($sanitizedWhatsapp)
                                                <a href="https://wa.me/{{ $sanitizedWhatsapp }}?text={{ $encodedWhatsappMessage }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:from-emerald-600 hover:to-emerald-700 hover:shadow-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                                    </svg>
                                                    Hubungi via WhatsApp
                                                </a>
                                            @endif
                                            @if ($decryptedAdminNotes)
                                                <div class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded-lg">
                                                    <div class="flex items-start gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                        </svg>
                                                        <p class="text-xs text-amber-800 flex-1">{{ $decryptedAdminNotes }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-slate-900">
                                                        {{ optional($archive->handler)->name ?? 'Tidak Diketahui' }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                        </svg>
                                                        Ditangani {{ optional($archive->handled_at)->diffForHumans() ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-2">
                                                <span class="inline-flex items-center gap-1.5 self-start rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $consultationStatusLabels[$archive->status] ?? ucfirst($archive->status) }}
                                                </span>
                                                <div class="text-xs text-slate-500 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                    </svg>
                                                    Diarsipkan {{ optional($archive->archived_at)->translatedFormat('d M Y, H:i') ?? '-' }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-12 text-center text-sm text-slate-500" colspan="4">
                                            <div class="flex flex-col items-center justify-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                                <div>
                                                    <p class="font-medium text-slate-600">Belum ada arsip konsultasi.</p>
                                                    <p class="mt-1 text-xs text-slate-500">Semua konsultasi yang telah diselesaikan akan muncul di sini.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($archives instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                            {{ $archives->withQueryString()->links() }}
                        </div>
                    @endif
                </section>
            </section>
        </main>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
