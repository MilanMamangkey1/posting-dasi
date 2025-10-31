@extends('layouts.admin')

@section('title', 'Kelola Pengajuan Konsultasi')

@section('body')
    <header class="bg-white border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-semibold text-slate-900">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 8.25h9m-9 3h6M2.25 12a8.25 8.25 0 1115.573 4.032l1.32 3.3a.75.75 0 01-.966.966l-3.3-1.32A8.25 8.25 0 012.25 12z" />
                        </svg>
                    </span>
                    Kelola Pengajuan Konsultasi
                </h1>
                <p class="text-sm text-slate-600">Pantau antrian konsultasi dan perbarui status secara cepat.</p>
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
                <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                    <p class="font-semibold">Terdapat beberapa masalah dengan data yang Anda kirim:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-900">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 6.75h15m-12 4.5h9m-9 4.5h5.25M6 3h12a1.5 1.5 0 011.5 1.5v15A1.5 1.5 0 0118 21H6a1.5 1.5 0 01-1.5-1.5v-15A1.5 1.5 0 016 3z" />
                                </svg>
                            </span>
                            Daftar Pengajuan Konsultasi
                        </h2>
                        <p class="text-sm text-slate-600">Saring berdasarkan status, rentang waktu, atau cari nama/nomor WhatsApp.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.consultations.index') }}" class="flex flex-wrap items-end gap-3 text-sm text-slate-700">
                        <div class="flex flex-col">
                            <label for="consultation_status" class="text-xs uppercase text-red-600">Status</label>
                            <select id="consultation_status" name="consultation_status" class="form-input w-48">
                                <option value="">Semua status</option>
                                @foreach ($consultationStatuses as $status)
                                    <option value="{{ $status }}" @selected($consultationFilters['status'] === $status)>{{ $consultationStatusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="consultation_range" class="text-xs uppercase text-red-600">Rentang Waktu</label>
                            <select id="consultation_range" name="consultation_range" class="form-input w-48">
                                @foreach ($consultationDateRanges as $value => $label)
                                    <option value="{{ $value }}" @selected($consultationFilters['date_range'] === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="consultation_search" class="text-xs uppercase text-red-600">Cari nama/no. WhatsApp</label>
                            <input id="consultation_search" type="search" name="consultation_search" value="{{ $consultationFilters['search'] }}" class="form-input w-72" placeholder="Cari pengajuan">
                        </div>
                        <button type="submit" class="secondary-button">Terapkan Penyaringan</button>
                    </form>
                </div>

                <section class="panel">
                    <header class="panel__header">
                        <h3 class="flex items-center gap-2">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 7.5h16.5M6 10.5v7.5m6-7.5v7.5m6-7.5v7.5" />
                                </svg>
                            </span>
                            Antrian Konsultasi
                        </h3>
                    </header>
                    <div class="overflow-hidden rounded-lg border border-slate-200 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                                    <tr>
                                        <th class="px-4 py-3">Pemohon &amp; Permasalahan</th>
                                        <th class="px-4 py-3">Status &amp; Tindak Lanjut</th>
                                        <th class="px-4 py-3">Kontak &amp; Alamat</th>
                                        <th class="px-4 py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($consultations as $consultation)
                                        @php
                                            $sanitizedWhatsapp = preg_replace('/[^0-9]/', '', $consultation->whatsapp_number ?? '');
                                            $issueSummary = trim(preg_replace('/\s+/', ' ', $consultation->issue_description ?? ''));
                                            $issueSegment = $issueSummary !== '' ? "({$issueSummary})" : '';
                                            $greeting = "Halo, {$consultation->full_name} kami dari DInas PPKBD Kota Tomohon akan memberikan konsultasi terkait dengan keluhan anda";
                                            if ($issueSegment !== '') {
                                                $greeting .= " {$issueSegment}";
                                            }
                                            $whatsappMessage = $greeting . "\n\n";
                                            $whatsappMessage .= "Berikut Dibawah ini adalah jawaban dari keluhan anda:\n\n";
                                            $whatsappMessage .= "Jika ada yang ingin ditanyakan lagi jangan sungkan,\n";
                                            $whatsappMessage .= "Homat Kami DInas PPKBD kota Tomohon";
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
                                        <tr class="{{ $loop->even ? 'bg-slate-50' : 'bg-white' }}">
                                            <td class="align-top px-4 py-4">
                                                <div class="flex flex-col gap-3">
                                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                                        <span class="font-semibold text-slate-900">{{ $consultation->full_name }}</span>
                                                        @if ($submittedAt)
                                                            <span class="text-xs text-slate-500">Diajukan {{ $submittedAt }}</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm leading-relaxed text-slate-600">{{ $issuePreview }}</p>
                                                    @if ($isIssueTruncated)
                                                        <details class="text-xs text-slate-500">
                                                            <summary class="cursor-pointer font-medium text-red-600 hover:text-red-700">Lihat rincian permasalahan</summary>
                                                            <p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $consultation->issue_description }}</p>
                                                        </details>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="align-top px-4 py-4">
                                                <div class="flex flex-col gap-3">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusBadgeClass }}">
                                                            <span class="inline-block h-2 w-2 rounded-full bg-current"></span>
                                                            {{ $statusLabel }}
                                                        </span>
                                                        @if ($lastUpdatedAt && $lastUpdatedAt !== $submittedAt)
                                                            <span class="text-xs text-slate-500">Diperbarui {{ $lastUpdatedAt }}</span>
                                                        @endif
                                                    </div>
                                                    @if ($consultation->admin_notes)
                                                        <p class="rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-xs leading-relaxed text-slate-600">
                                                            <span class="font-semibold text-slate-700">Catatan admin:</span>
                                                            {{ $consultation->admin_notes }}
                                                        </p>
                                                    @endif
                                                    <details class="group text-sm text-slate-700">
                                                        <summary class="cursor-pointer font-semibold text-red-600 hover:text-red-700">Ubah status &amp; catatan</summary>
                                                        <div class="mt-3 space-y-3 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
                                                            <form method="POST" action="{{ route('admin.consultations.update', $consultation) }}" class="space-y-3">
                                                                @csrf
                                                                @method('PUT')
                                                                <div>
                                                                    <label for="status-{{ $consultation->id }}" class="mb-1 block text-xs font-semibold uppercase text-slate-500">Status</label>
                                                                    <select id="status-{{ $consultation->id }}" name="status" class="form-input">
                                                                        @foreach ($consultationStatuses as $status)
                                                                            <option value="{{ $status }}" @selected($consultation->status === $status)>{{ $consultationStatusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label for="admin_notes-{{ $consultation->id }}" class="mb-1 block text-xs font-semibold uppercase text-slate-500">Catatan admin</label>
                                                                    <textarea id="admin_notes-{{ $consultation->id }}" name="admin_notes" rows="2" class="form-input" placeholder="Catatan admin (opsional)" data-auto-resize>{{ $consultation->admin_notes }}</textarea>
                                                                </div>
                                                                <div class="flex justify-end">
                                                                    <button type="submit" class="primary-button">Simpan perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </details>
                                                </div>
                                            </td>
                                            <td class="align-top px-4 py-4 text-sm text-slate-600">
                                                <div class="space-y-2">
                                                    <div>
                                                        <span class="text-xs font-semibold uppercase text-slate-500">Nomor WhatsApp</span>
                                                        <div class="font-medium text-slate-700">{{ $consultation->whatsapp_number ?? '-' }}</div>
                                                        @if ($sanitizedWhatsapp)
                                                            <a href="https://wa.me/{{ $sanitizedWhatsapp }}?text={{ $encodedWhatsappMessage }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                                                    <path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 00-8.469 14.84l-1.05 3.817a1.125 1.125 0 001.383 1.383l3.818-1.05A9.75 9.75 0 1012 2.25zm0 2.25a7.5 7.5 0 00-6.514 11.233.75.75 0 01.06.574l-.75 2.729 2.73-.75a.75.75 0 01.573.06A7.5 7.5 0 1012 4.5zm3.018 8.038c-.175-.088-1.03-.508-1.188-.565-.16-.059-.277-.088-.394.087-.118.175-.453.565-.556.682-.102.118-.205.133-.38.044-.175-.088-.738-.272-1.407-.868-.52-.463-.872-1.036-.974-1.211-.102-.175-.01-.27.077-.357.079-.078.175-.205.262-.307.087-.102.116-.175.175-.292.058-.117.029-.219-.015-.307-.044-.087-.394-.949-.54-1.299-.142-.34-.286-.295-.394-.3-.102-.004-.219-.005-.336-.005-.117 0-.307.044-.468.22-.16.175-.61.596-.61 1.456 0 .86.623 1.688.71 1.805.087.117 1.226 1.874 2.974 2.626 1.041.449 1.45.488 1.97.41.317-.047 1.03-.42 1.176-.826.145-.405.145-.751.102-.826-.043-.074-.16-.117-.336-.205z" clip-rule="evenodd" />
                                                                </svg>
                                                                Hubungi via WhatsApp
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="text-xs font-semibold uppercase text-slate-500">Alamat</span>
                                                        <p class="text-sm leading-relaxed text-slate-600">{{ $consultation->address }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-top px-4 py-4 text-right text-sm text-slate-600">
                                                <form method="POST" action="{{ route('admin.consultations.destroy', $consultation) }}" onsubmit="return confirm('Hapus pengajuan ini?');" class="inline-flex">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="danger-button">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-4 text-sm text-red-600" colspan="4">
                                                Belum ada pengajuan konsultasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($consultations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">{{ $consultations->links() }}</div>
                    @endif
                </section>
            </section>
        </main>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var autoResizeTargets = document.querySelectorAll('[data-auto-resize]');
                if (!autoResizeTargets.length) {
                    return;
                }

                autoResizeTargets.forEach(function (textarea) {
                    var resize = function () {
                        textarea.style.height = 'auto';
                        textarea.style.height = textarea.scrollHeight + 'px';
                    };

                    textarea.addEventListener('input', resize);
                    resize();
                });
            });
        </script>
    @endpush
@endsection
