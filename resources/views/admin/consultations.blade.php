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

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row">
        @include('admin.partials.sidebar', ['active' => 'consultations'])

        <main class="flex-1 space-y-12">
            @if ($statusMessage)
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ $statusMessage }}
                </div>
            @endif

            @if ($statusError)
                <div class="rounded-lg border border-red-600 bg-white px-4 py-3 text-sm text-red-600">
                    {{ $statusError }}
                </div>
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
                        <p class="text-sm text-slate-600">Saring berdasarkan status atau cari nama/nomor WhatsApp.</p>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm text-slate-700">
                            <thead class="border-b border-slate-200 text-xs font-semibold uppercase text-red-600">
                                <tr>
                                    <th class="px-4 py-3">Pemohon</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Kontak</th>
                                    <th class="px-4 py-3">Alamat</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse ($consultations as $consultation)
                                    @php($sanitizedWhatsapp = preg_replace('/[^0-9]/', '', $consultation->whatsapp_number ?? ''))
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-slate-900">{{ $consultation->full_name }}</div>
                                            <details class="mt-1 text-xs text-slate-500">
                                                <summary class="cursor-pointer font-medium text-red-600 hover:text-red-600">
                                                    Rincian Permasalahan
                                                </summary>
                                                <p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $consultation->issue_description }}</p>
                                                @if ($consultation->admin_notes)
                                                    <p class="mt-2 text-xs text-slate-500">Catatan Admin: {{ $consultation->admin_notes }}</p>
                                                @endif
                                            </details>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">
                                            <form method="POST" action="{{ route('admin.consultations.update', $consultation) }}" class="space-y-2">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-input">
                                                    @foreach ($consultationStatuses as $status)
                                                    <option value="{{ $status }}" @selected($consultation->status === $status)>{{ $consultationStatusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="admin_notes" rows="2" class="form-input" placeholder="Catatan admin (opsional)">{{ $consultation->admin_notes }}</textarea>
                                                <button type="submit" class="primary-button">Simpan Status</button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">
                                            <div>{{ $consultation->whatsapp_number ?? '-' }}</div>
                                            @if ($sanitizedWhatsapp)
                                                <a href="https://wa.me/{{ $sanitizedWhatsapp }}" target="_blank" rel="noopener" class="accent-link">
                                                    Hubungi melalui WhatsApp
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $consultation->address }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-slate-600">
                                            <form method="POST" action="{{ route('admin.consultations.destroy', $consultation) }}" onsubmit="return confirm('Hapus pengajuan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="danger-button">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-red-600" colspan="5">
                                            Belum ada pengajuan konsultasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($consultations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">{{ $consultations->withQueryString()->links() }}</div>
                    @endif
                </section>
            </section>
        </main>
    </div>
@endsection


