@extends('layouts.admin')

@section('title', 'Kelola Pengajuan Konsultasi')

@section('body')
    <header class="bg-white border-b border-slate-200 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Kelola Pengajuan Konsultasi
                </h1>
                <p class="mt-1 text-sm text-slate-600">Pantau antrian konsultasi dan perbarui status secara cepat.</p>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row lg:items-start lg:gap-10">
        @include('admin.partials.sidebar', ['active' => 'consultations'])

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

            @if ($errors->any())
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-800 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="font-semibold">Terdapat beberapa masalah dengan data yang Anda kirim:</p>
                            <ul class="mt-2 list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <section class="space-y-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @php
                        $stats = [
                            'total' => ['label' => 'Total Pengajuan', 'count' => $consultations->total(), 'color' => 'blue', 'icon' => '📋'],
                            'pending' => ['label' => 'Menunggu', 'count' => $consultations->where('status', 'pending')->count(), 'color' => 'amber', 'icon' => '⏳'],
                            'in_progress' => ['label' => 'Diproses', 'count' => $consultations->where('status', 'in_progress')->count(), 'color' => 'purple', 'icon' => '🔄'],
                            'resolved' => ['label' => 'Selesai', 'count' => $consultations->where('status', 'resolved')->count(), 'color' => 'emerald', 'icon' => '✅'],
                        ];
                    @endphp
                    
                    @foreach($stats as $key => $stat)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">{{ $stat['label'] }}</p>
                                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stat['count'] }}</p>
                                </div>
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-{{ $stat['color'] }}-500 to-{{ $stat['color'] }}-600 text-white shadow-sm">
                                    <span class="text-lg">{{ $stat['icon'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-3 text-xl font-bold text-slate-900">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Daftar Pengajuan Konsultasi
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Saring berdasarkan status, rentang waktu, atau cari nama/nomor WhatsApp.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.consultations.index') }}" class="flex flex-wrap items-end gap-4 text-sm text-slate-700">
                        <div class="flex flex-col">
                            <label for="consultation_status" class="text-xs font-semibold uppercase tracking-wide text-purple-600 mb-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Status
                            </label>
                            <select id="consultation_status" name="consultation_status" class="form-input w-48 rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200">
                                <option value="">Semua status</option>
                                @foreach ($consultationStatuses as $status)
                                    <option value="{{ $status }}" @selected($consultationFilters['status'] === $status)>{{ $consultationStatusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="consultation_range" class="text-xs font-semibold uppercase tracking-wide text-purple-600 mb-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                Rentang Waktu
                            </label>
                            <select id="consultation_range" name="consultation_range" class="form-input w-48 rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200">
                                @foreach ($consultationDateRanges as $value => $label)
                                    <option value="{{ $value }}" @selected($consultationFilters['date_range'] === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="consultation_search" class="text-xs font-semibold uppercase tracking-wide text-purple-600 mb-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Cari nama/no. WhatsApp
                            </label>
                            <input id="consultation_search" type="search" name="consultation_search" value="{{ $consultationFilters['search'] }}" class="form-input w-72 rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200" placeholder="Cari pengajuan">
                        </div>
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Terapkan Penyaringan
                        </button>
                    </form>
                </div>

                <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <header class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
                        <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-900">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                                    <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                </svg>
                            </span>
                            Antrian Konsultasi
                        </h3>
                    </header>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-700">
                            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase text-purple-600">
                                <tr>
                                    <th class="px-6 py-4">Pemohon &amp; Permasalahan</th>
                                    <th class="px-6 py-4">Status &amp; Tindak Lanjut</th>
                                    <th class="px-6 py-4">Kontak &amp; Alamat</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @forelse ($consultations as $consultation)
                                    @php
                                        $sanitizedWhatsapp = preg_replace('/[^0-9]/', '', $consultation->whatsapp_number ?? '');
                                        $issueSummary = trim(preg_replace('/\s+/', ' ', $consultation->issue_description ?? ''));
                                        $issueSegment = $issueSummary !== '' ? "({$issueSummary})" : '';
                                        $greeting = "Halo, {$consultation->full_name} kami dari Dinas PPKBD Kota Tomohon akan memberikan konsultasi terkait dengan keluhan anda";
                                        if ($issueSegment !== '') {
                                            $greeting .= " {$issueSegment}";
                                        }
                                        $whatsappMessage = $greeting . "\n\n";
                                        $whatsappMessage .= "Jika ada yang ingin ditanyakan lagi jangan sungkan,\n";
                                        $whatsappMessage .= "Hormat Kami Dinas PPKBD kota Tomohon\n\n";
                                        $encodedWhatsappMessage = rawurlencode($whatsappMessage);

                                        $statusColors = [
                                            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
                                            'in_progress' => 'bg-sky-100 text-sky-700 ring-sky-200',
                                            'resolved' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                            'closed' => 'bg-slate-100 text-slate-700 ring-slate-200',
                                        ];

                                        $statusBadgeClass = $statusColors[$consultation->status] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
                                        $statusLabel = $consultationStatusLabels[$consultation->status] ?? ucfirst(str_replace('_', ' ', $consultation->status));
                                        $submittedAt = $consultation->created_at ? $consultation->created_at->format('d M Y H:i') : null;
                                        $lastUpdatedAt = $consultation->updated_at ? $consultation->updated_at->format('d M Y H:i') : null;
                                        $issueBody = (string) ($consultation->issue_description ?? '');
                                        $issuePreview = \Illuminate\Support\Str::limit($issueBody, 140);
                                        $isIssueTruncated = \Illuminate\Support\Str::length($issueBody) > \Illuminate\Support\Str::length($issuePreview);
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors duration-150 group">
                                        <td class="px-6 py-6">
                                            <div class="flex flex-col gap-3">
                                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                                    <span class="font-semibold text-slate-900 text-lg">{{ $consultation->full_name }}</span>
                                                    @if ($submittedAt)
                                                        <span class="inline-flex items-center gap-1 text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                            </svg>
                                                            Diajukan {{ $submittedAt }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm leading-relaxed text-slate-600 bg-slate-50 rounded-lg p-3 border border-slate-200">
                                                    {{ $issuePreview }}
                                                </p>
                                                @if ($isIssueTruncated)
                                                    <details class="text-sm text-slate-500">
                                                        <summary class="cursor-pointer font-medium text-purple-600 hover:text-purple-700 flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                            Lihat rincian permasalahan
                                                        </summary>
                                                        <div class="mt-3 p-4 bg-white border border-slate-200 rounded-lg shadow-sm">
                                                            <p class="whitespace-pre-line text-slate-700 leading-relaxed">{{ $consultation->issue_description }}</p>
                                                        </div>
                                                    </details>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="flex flex-col gap-4">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $statusBadgeClass }}">
                                                        <span class="inline-block h-2 w-2 rounded-full bg-current"></span>
                                                        {{ $statusLabel }}
                                                    </span>
                                                    @if ($lastUpdatedAt && $lastUpdatedAt !== $submittedAt)
                                                        <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                                            Diperbarui {{ $lastUpdatedAt }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if ($consultation->admin_notes)
                                                    <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">
                                                        <p class="text-sm leading-relaxed text-blue-800">
                                                            <span class="font-semibold">📝 Catatan admin:</span>
                                                            {{ $consultation->admin_notes }}
                                                        </p>
                                                    </div>
                                                @endif
                                                <details class="group">
                                                    <summary class="cursor-pointer flex items-center gap-2 font-semibold text-purple-600 hover:text-purple-700 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Ubah status & catatan
                                                    </summary>
                                                    <div class="mt-4 space-y-4 rounded-xl border border-slate-200 bg-white p-4 shadow-lg">
                                                        <form method="POST" action="{{ route('admin.consultations.update', $consultation) }}" class="space-y-4">
                                                            @csrf
                                                            @method('PUT')
                                                            <div>
                                                                <label for="status-{{ $consultation->id }}" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Status</label>
                                                                <select id="status-{{ $consultation->id }}" name="status" class="form-input rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 w-full">
                                                                    @foreach ($consultationStatuses as $status)
                                                                        <option value="{{ $status }}" @selected($consultation->status === $status)>{{ $consultationStatusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label for="admin_notes-{{ $consultation->id }}" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Catatan admin</label>
                                                                <textarea id="admin_notes-{{ $consultation->id }}" name="admin_notes" rows="3" class="form-input rounded-lg border-slate-300 focus:border-purple-500 focus:ring-purple-500 w-full" placeholder="Catatan admin (opsional)" data-auto-resize>{{ $consultation->admin_notes }}</textarea>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    Simpan Perubahan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </details>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="space-y-4">
                                                <div>
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2 block">Nomor WhatsApp</span>
                                                    <div class="font-medium text-slate-900 text-lg">{{ $consultation->whatsapp_number ?? '-' }}</div>
                                                    @if ($sanitizedWhatsapp)
                                                        <a href="https://wa.me/{{ $sanitizedWhatsapp }}?text={{ $encodedWhatsappMessage }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:from-emerald-600 hover:to-emerald-700 hover:shadow-md">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                                            </svg>
                                                            Hubungi via WhatsApp
                                                        </a>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2 block">Alamat</span>
                                                    <p class="text-sm leading-relaxed text-slate-700 bg-slate-50 rounded-lg p-3 border border-slate-200">
                                                        {{ $consultation->address }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-right">
                                            <form method="POST" action="{{ route('admin.consultations.destroy', $consultation) }}" onsubmit="return confirm('Hapus pengajuan ini?');" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-sm text-slate-500" colspan="4">
                                            <div class="flex flex-col items-center justify-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="font-medium text-slate-600 text-lg">Belum ada pengajuan konsultasi.</span>
                                                <p class="text-slate-500">Pengajuan konsultasi yang masuk akan muncul di sini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($consultations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                            {{ $consultations->withQueryString()->links() }}
                        </div>
                    @endif
                </section>
            </section>
        </main>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Auto-resize textareas
                const autoResizeTargets = document.querySelectorAll('[data-auto-resize]');
                autoResizeTargets.forEach(function (textarea) {
                    const resize = function () {
                        textarea.style.height = 'auto';
                        textarea.style.height = textarea.scrollHeight + 'px';
                    };
                    textarea.addEventListener('input', resize);
                    resize();
                });

                // Add smooth animations for details elements
                document.querySelectorAll('details').forEach(details => {
                    details.addEventListener('toggle', function() {
                        if (this.open) {
                            this.style.transition = 'all 0.3s ease-in-out';
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection