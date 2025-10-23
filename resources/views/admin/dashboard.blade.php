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
            <nav class="flex flex-wrap gap-2 text-sm font-medium text-slate-700" aria-label="Sections">
                <a href="#metrics" class="rounded-lg border border-slate-300 px-4 py-2 hover:border-slate-400 hover:text-slate-900">
                    Ringkasan
                </a>
                <a href="#contents" class="rounded-lg border border-slate-300 px-4 py-2 hover:border-slate-400 hover:text-slate-900">
                    Konten Edukasi
                </a>
                <a href="#consultations" class="rounded-lg border border-slate-300 px-4 py-2 hover:border-slate-400 hover:text-slate-900">
                    Pengajuan Konsultasi
                </a>
            </nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="secondary-button">
                    Keluar {{ auth()->user()?->name ? '('.auth()->user()->name.')' : '' }}
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-7xl space-y-12 px-6 py-8">
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

        <section id="metrics" class="space-y-6">
            <h2 class="text-xl font-semibold text-slate-900">Ringkasan Data</h2>
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
                </section>
            </div>
        </section>

        <section id="contents" class="space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-xl font-semibold text-slate-900">Kelola Konten Edukasi</h2>
                <form method="GET" class="flex flex-wrap items-end gap-3 text-sm text-slate-700">
                    <div class="flex flex-col">
                        <label for="content_type" class="text-xs uppercase text-slate-500">Jenis</label>
                        <select id="content_type" name="content_type" class="form-input w-48">
                            <option value="">Semua jenis</option>
                            @foreach ($contentTypes as $type)
                                <option value="{{ $type }}" @selected($contentFilters['type'] === $type)>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="content_search" class="text-xs uppercase text-slate-500">Cari judul</label>
                        <input
                            id="content_search"
                            type="search"
                            name="content_search"
                            value="{{ $contentFilters['search'] }}"
                            class="form-input w-56"
                        >
                    </div>
                    <button type="submit" class="secondary-button">Terapkan</button>
                </form>
            </div>

            <section class="panel">
                <header class="panel__header">
                    <div>
                        <h3>Tambah Konten</h3>
                        <p class="panel__sub">Isi form sesuai jenis konten. Validasi akhir dilakukan di backend.</p>
                    </div>
                </header>
                <form method="POST" action="{{ route('admin.contents.store') }}" enctype="multipart/form-data" class="space-y-4" data-content-form>
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="form-field">
                            <span>Judul</span>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-input">
                        </label>
                        <label class="form-field">
                            <span>Jenis</span>
                            <select name="type" class="form-input" data-field-control="type">
                                <option value="">Pilih jenis</option>
                                @foreach ($contentTypes as $type)
                                    <option value="{{ $type }}" @selected(old('type') === $type)>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <label class="form-field">
                        <span>Ringkasan</span>
                        <textarea name="summary" rows="3" class="form-input">{{ old('summary') }}</textarea>
                    </label>
                    <label class="form-field {{ old('type') === 'video' ? '' : 'hidden' }}" data-field-for="video">
                        <span>Tautan Video (gunakan jika jenis video)</span>
                        <input type="url" name="source_url" value="{{ old('source_url') }}" class="form-input" placeholder="https://www.youtube.com/watch?v=...">
                    </label>
                    <label class="form-field {{ in_array(old('type'), ['narrative', 'material'], true) ? '' : 'hidden' }}" data-field-for="narrative material">
                        <span>Isi Narasi/Materi (gunakan jika jenis narasi atau materi)</span>
                        <textarea name="body" rows="5" class="form-input">{{ old('body') }}</textarea>
                    </label>
                    <label class="form-field {{ old('type') === 'photo' ? '' : 'hidden' }}" data-field-for="photo">
                        <span>Unggah Foto (gunakan jika jenis foto, maksimal 5 MB)</span>
                        <input type="file" name="file" class="form-input" accept=".jpg,.jpeg,.png,.gif,.webp">
                    </label>
                    <button type="submit" class="primary-button">Simpan Konten</button>
                </form>
            </section>

            <section class="panel space-y-4">
                <header class="panel__header">
                    <div>
                        <h3>Daftar Konten</h3>
                        <p class="panel__sub">Edit langsung setiap entri tanpa modul JavaScript.</p>
                    </div>
                </header>
                @forelse ($contents as $content)
                    <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900">{{ $content->title }}</h4>
                                <p class="text-xs uppercase text-slate-500">Jenis: {{ $content->type }}</p>
                                @if ($content->summary)
                                    <p class="mt-2 text-sm text-slate-600">{{ $content->summary }}</p>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('Hapus konten ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger-button">Hapus</button>
                            </form>
                        </div>
                        <details class="mt-4 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                            <summary class="cursor-pointer text-sm font-medium text-slate-700">
                                Ubah Konten
                            </summary>
                            <form method="POST" action="{{ route('admin.contents.update', $content) }}" enctype="multipart/form-data" class="mt-4 space-y-3" data-content-form>
                                @csrf
                                @method('PUT')
                                <label class="form-field">
                                    <span>Judul</span>
                                    <input type="text" name="title" value="{{ $content->title }}" class="form-input">
                                </label>
                                <label class="form-field">
                                    <span>Jenis</span>
                                    <select name="type" class="form-input" data-field-control="type">
                                        @foreach ($contentTypes as $type)
                                            <option value="{{ $type }}" @selected($content->type === $type)>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="form-field">
                                    <span>Ringkasan</span>
                                    <textarea name="summary" rows="3" class="form-input">{{ $content->summary }}</textarea>
                                </label>
                                <label class="form-field {{ $content->type === 'video' ? '' : 'hidden' }}" data-field-for="video">
                                    <span>Tautan Video</span>
                                    <input type="url" name="source_url" value="{{ $content->source_url }}" class="form-input">
                                </label>
                                <label class="form-field {{ in_array($content->type, ['narrative', 'material'], true) ? '' : 'hidden' }}" data-field-for="narrative material">
                                    <span>Isi Narasi / Materi</span>
                                    <textarea name="body" rows="4" class="form-input">{{ $content->body }}</textarea>
                                </label>
                                <label class="form-field {{ $content->type === 'photo' ? '' : 'hidden' }}" data-field-for="photo">
                                    <span>Ganti Foto (opsional)</span>
                                    <input type="file" name="file" class="form-input" accept=".jpg,.jpeg,.png,.gif,.webp">
                                    @if ($content->file_path)
                                        <span class="text-xs text-slate-500">Foto saat ini: {{ $content->file_path }}</span>
                                    @endif
                                </label>
                                <button type="submit" class="primary-button">Perbarui Konten</button>
                            </form>
                        </details>
                    </article>
                @empty
                    <p class="text-sm text-slate-600">Belum ada konten terdaftar.</p>
                @endforelse

                @if ($contents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div>{{ $contents->withQueryString()->links() }}</div>
                @endif
            </section>
        </section>

        <section id="consultations" class="space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-xl font-semibold text-slate-900">Kelola Pengajuan Konsultasi</h2>
                <form method="GET" class="flex flex-wrap items-end gap-3 text-sm text-slate-700">
                    <div class="flex flex-col">
                        <label for="consultation_status" class="text-xs uppercase text-slate-500">Status</label>
                        <select id="consultation_status" name="consultation_status" class="form-input w-48">
                            <option value="">Semua status</option>
                            @foreach ($consultationStatuses as $status)
                                <option value="{{ $status }}" @selected($consultationFilters['status'] === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="consultation_search" class="text-xs uppercase text-slate-500">Cari nama/nomor</label>
                        <input
                            id="consultation_search"
                            type="search"
                            name="consultation_search"
                            value="{{ $consultationFilters['search'] }}"
                            class="form-input w-56"
                        >
                    </div>
                    <button type="submit" class="secondary-button">Terapkan</button>
                </form>
            </div>

            <section class="panel">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Kontak WhatsApp</th>
                                <th class="px-4 py-3 text-left">Alamat</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($consultations as $consultation)
                                @php
                                    $sanitizedWhatsapp = preg_replace('/\D+/', '', $consultation->whatsapp_number ?? '');
                                @endphp
                                <tr class="align-top">
                                    <td class="px-4 py-3 font-medium text-slate-800">
                                        <div>{{ $consultation->full_name }}</div>
                                        <details class="mt-2 rounded border border-slate-200 bg-slate-50 px-3 py-2">
                                            <summary class="cursor-pointer text-xs font-medium text-slate-600">Detail Permasalahan</summary>
                                            <p class="mt-2 whitespace-pre-line text-sm text-slate-700">{{ $consultation->issue_description }}</p>
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
                                                    <option value="{{ $status }}" @selected($consultation->status === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                                @endforeach
                                            </select>
                                            <textarea name="admin_notes" rows="2" class="form-input" placeholder="Catatan admin (opsional)">{{ $consultation->admin_notes }}</textarea>
                                            <button type="submit" class="primary-button">Simpan Status</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        <div>{{ $consultation->whatsapp_number ?? '-' }}</div>
                                        @if ($sanitizedWhatsapp)
                                            <a href="https://wa.me/{{ $sanitizedWhatsapp }}" target="_blank" rel="noopener" class="text-sm font-semibold text-slate-900 hover:underline">
                                                Hubungi via WhatsApp
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        {{ $consultation->address }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        <form method="POST" action="{{ route('admin.consultations.destroy', $consultation) }}" onsubmit="return confirm('Hapus pengajuan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="danger-button">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-4 text-sm text-slate-500" colspan="5">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form[data-content-form]').forEach(function (form) {
                const typeControl = form.querySelector('[data-field-control="type"]');
                if (!typeControl) {
                    return;
                }

                const fieldGroups = Array.from(form.querySelectorAll('[data-field-for]'));

                const toggleFields = function () {
                    const currentType = typeControl.value;
                    fieldGroups.forEach(function (group) {
                        const allowedTypes = group.dataset.fieldFor.split(' ');
                        if (currentType && allowedTypes.includes(currentType)) {
                            group.classList.remove('hidden');
                        } else {
                            group.classList.add('hidden');
                            group.querySelectorAll('input:not([type="file"]), textarea').forEach(function (input) {
                                input.value = '';
                            });
                        }
                    });
                };

                toggleFields();
                typeControl.addEventListener('change', toggleFields);
            });
        });
    </script>
@endsection
