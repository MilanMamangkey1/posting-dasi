@extends('layouts.admin')

@section('title', 'Kelola Konten Edukasi')

@section('body')
    <header class="bg-white border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-semibold text-slate-900">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 5.25c0-.621.504-1.125 1.125-1.125h5.25A2.625 2.625 0 0112.75 6.75v13.5c0-1.242-1.008-2.25-2.25-2.25h-5.25a1.125 1.125 0 01-1.125-1.125V5.25zM20.25 18.75c0 .621-.504 1.125-1.125 1.125h-5.25A2.625 2.625 0 0111.25 17.25V3.75c0 1.242 1.008 2.25 2.25 2.25h5.25c.621 0 1.125.504 1.125 1.125v11.625z" />
                        </svg>
                    </span>
                    Kelola Konten Edukasi
                </h1>
                <p class="text-sm text-slate-600">Tambahkan video, foto, narasi, dan materi edukasi langsung dari area admin.</p>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row lg:items-start lg:gap-10">
        @include('admin.partials.sidebar', ['active' => 'contents'])

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
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 5.25c0-.621.504-1.125 1.125-1.125h5.25A2.625 2.625 0 0112.75 6.75v13.5c0-1.242-1.008-2.25-2.25-2.25h-5.25a1.125 1.125 0 01-1.125-1.125V5.25zM20.25 18.75c0 .621-.504 1.125-1.125 1.125h-5.25A2.625 2.625 0 0111.25 17.25V3.75c0 1.242 1.008 2.25 2.25 2.25h5.25c.621 0 1.125.504 1.125 1.125v11.625z" />
                                </svg>
                            </span>
                            Kelola Konten Edukasi
                        </h2>
                        <p class="text-sm text-slate-600">Gunakan penyaringan untuk menampilkan konten berdasarkan jenis atau judul.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.contents.index') }}" class="flex flex-wrap items-end gap-3 text-sm text-slate-700">
                        <div class="flex flex-col">
                            <label for="content_type" class="text-xs uppercase text-red-600">Jenis</label>
                            <select id="content_type" name="content_type" class="form-input w-48">
                                <option value="">Semua jenis</option>
                                @foreach ($contentTypes as $type)
                                    <option value="{{ $type }}" @selected($contentFilters['type'] === $type)>{{ $contentTypeLabels[$type] ?? ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="content_search" class="text-xs uppercase text-red-600">Cari judul</label>
                            <input id="content_search" type="search" name="content_search" value="{{ $contentFilters['search'] }}" class="form-input w-72" placeholder="Cari judul konten">
                        </div>
                        <button type="submit" class="secondary-button">Terapkan Penyaringan</button>
                    </form>
                </div>

                <div class="space-y-6">
                    <section class="panel">
                        <header class="panel__header">
                            <h3 class="flex items-center gap-2">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                                    </svg>
                                </span>
                                Tambah Konten Edukasi
                            </h3>
                        </header>
                        <form method="POST" action="{{ route('admin.contents.store') }}" enctype="multipart/form-data" class="space-y-4" data-content-form>
                            @csrf
                            <div class="space-y-1">
                                <label class="form-label" for="title">Judul</label>
                                <input class="form-input" type="text" id="title" name="title" value="{{ old('title') }}" required>
                            </div>
                            <div class="space-y-1">
                                <label class="form-label" for="type">Jenis Konten</label>
                                <select class="form-input" id="type" name="type" data-field-control="type" required>
                                    <option value="">Pilih jenis konten</option>
                                    @foreach ($contentTypes as $type)
                                        <option value="{{ $type }}" @selected(old('type') === $type)>{{ $contentTypeLabels[$type] ?? ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="form-label" for="summary">Ringkasan Singkat</label>
                                <textarea class="form-input" id="summary" name="summary" rows="2">{{ old('summary') }}</textarea>
                            </div>

                            <div class="space-y-1">
                                <label class="form-label" for="event_date">Tanggal Kegiatan (opsional)</label>
                                <input
                                    class="form-input"
                                    type="date"
                                    id="event_date"
                                    name="event_date"
                                    value="{{ old('event_date') }}"
                                >
                                <p class="text-xs text-slate-500">Isi tanggal kegiatan berlangsung atau biarkan kosong bila tidak diperlukan.</p>
                            </div>

                            <div class="space-y-1" data-field-for="video">
                                <label class="form-label" for="source_url">Tautan Video YouTube</label>
                                <input class="form-input" type="url" id="source_url" name="source_url" value="{{ old('source_url') }}">
                            </div>

                            <div class="space-y-1" data-field-for="photo">
                                <label class="form-label" for="file">Foto (maksimal 3 MB)</label>
                                <input class="form-input" type="file" id="file" name="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                            </div>

                            <div class="space-y-1" data-field-for="material">
                                <label class="form-label" for="material_file">Dokumen Materi (PDF, DOCX, PPTX &le; 3 MB)</label>
                                <input class="form-input" type="file" id="material_file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            </div>

                            <div class="space-y-1" data-field-for="narrative">
                                <label class="form-label" for="body">Konten Teks</label>
                                <textarea class="form-input" id="body" name="body" rows="5">{{ old('body') }}</textarea>
                            </div>

                            <button type="submit" class="primary-button">
                                Simpan Konten
                            </button>
                        </form>
                    </section>

                    <section class="panel">
                        <header class="panel__header">
                            <h3 class="flex items-center gap-2">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-red-600 bg-white text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.25 6h13.5M5.25 12h13.5M5.25 18h8.25" />
                                    </svg>
                                </span>
                                Konten Terdaftar
                            </h3>
                        </header>
                        <div class="overflow-hidden rounded-lg border border-slate-200 shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                                        <tr>
                                            <th class="px-4 py-3">Judul</th>
                                            <th class="px-4 py-3">Jenis</th>
                                            <th class="px-4 py-3">Ringkasan</th>
                                            <th class="px-4 py-3">Tanggal Upload</th>
                                            <th class="px-4 py-3 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @forelse ($contents as $content)
                                        <tr class="{{ $loop->even ? 'bg-slate-50' : 'bg-white' }}">
                                            <td class="align-top px-4 py-4 font-semibold text-slate-900">
                                                {{ $content->title }}
                                            </td>
                                            <td class="align-top px-4 py-4 uppercase text-xs text-red-600">
                                                {{ $contentTypeLabels[$content->type] ?? ucfirst($content->type) }}
                                            </td>
                                            <td class="align-top px-4 py-4 text-slate-600">
                                                <div>{{ $content->summary ?? '-' }}</div>
                                                @if ($content->photo_url)
                                                    <a
                                                        href="{{ $content->photo_url }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="mt-3 inline-block overflow-hidden rounded-md border border-slate-200 bg-white"
                                                    >
                                                        <img
                                                            src="{{ $content->photo_url }}"
                                                            alt="Pratinjau foto {{ $content->title }}"
                                                            class="h-24 w-24 object-cover transition duration-200 hover:scale-[1.05]"
                                                            loading="lazy"
                                                        >
                                                    </a>
                                                @elseif ($content->document_url)
                                                    @php
                                                        $listDocSizeBytes = $content->document_size_bytes;
                                                        $listDocLabel = null;
                                                        if ($listDocSizeBytes) {
                                                            $listUnits = ['B', 'KB', 'MB', 'GB', 'TB'];
                                                            $listSize = (float) $listDocSizeBytes;
                                                            $listIndex = 0;
                                                            while ($listSize >= 1024 && $listIndex < count($listUnits) - 1) {
                                                                $listSize /= 1024;
                                                                $listIndex++;
                                                            }
                                                            $listPrecision = $listIndex === 0 ? 0 : 1;
                                                            $listFormatted = number_format($listSize, $listPrecision);
                                                            $listFormatted = rtrim(rtrim($listFormatted, '0'), '.');
                                                            $listDocLabel = $listFormatted . ' ' . $listUnits[$listIndex];
                                                        }
                                                    @endphp
                                                    <a
                                                        href="{{ $content->document_url }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="mt-3 inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 hover:text-red-600"
                                                    >
                                                        <span>Unduh {{ strtoupper($content->document_extension ?? 'Berkas') }}</span>
                                                        @if ($listDocLabel)
                                                            <span class="text-red-600">({{ $listDocLabel }})</span>
                                                        @endif
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="align-top px-4 py-4 text-sm text-slate-500 whitespace-nowrap">
                                                @php
                                                    $uploadedAt = optional($content->event_date ?? $content->created_at)->format('d/m/Y');
                                                @endphp
                                                {{ $uploadedAt ?? '-' }}
                                            </td>
                                            <td class="align-top px-4 py-4 text-right">
                                                <details class="group inline-block text-left">
                                                    <summary class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 group-open:text-red-600">
                                                        Kelola
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4 transition-transform group-open:rotate-180">
                                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                                                        </svg>
                                                    </summary>
                                                    <div class="mt-2 w-80 space-y-4 rounded-lg border border-slate-200 bg-white p-4 shadow-lg">
                                                        <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('Hapus konten ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="danger-button w-full justify-center text-xs">Hapus</button>
                                                        </form>

                                                        <form method="POST" action="{{ route('admin.contents.update', $content) }}" enctype="multipart/form-data" class="space-y-3" data-content-form>
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="type" value="{{ $content->type }}" data-field-control="type">
                                                            <div class="space-y-1">
                                                                <label class="form-label text-xs" for="title_{{ $content->id }}">Judul</label>
                                                                <input class="form-input" type="text" id="title_{{ $content->id }}" name="title" value="{{ $content->title }}" required>
                                                            </div>
                                                            <div class="space-y-1">
                                                                <label class="form-label text-xs" for="summary_{{ $content->id }}">Ringkasan</label>
                                                                <textarea class="form-input" id="summary_{{ $content->id }}" name="summary" rows="2">{{ $content->summary }}</textarea>
                                                            </div>

                                                            <div class="space-y-1">
                                                                <label class="form-label text-xs" for="event_date_{{ $content->id }}">Tanggal Kegiatan (opsional)</label>
                                                                <input
                                                                    class="form-input"
                                                                    type="date"
                                                                    id="event_date_{{ $content->id }}"
                                                                    name="event_date"
                                                                    value="{{ old('event_date', optional($content->event_date)->format('Y-m-d')) }}"
                                                                >
                                                            </div>

                                                            <div class="space-y-1" data-field-for="video">
                                                                <label class="form-label text-xs" for="source_url_{{ $content->id }}">Tautan Video YouTube</label>
                                                                <input class="form-input" type="url" id="source_url_{{ $content->id }}" name="source_url" value="{{ $content->source_url }}">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="photo">
                                                                <label class="form-label text-xs" for="file_{{ $content->id }}">Foto (opsional)</label>
                                                                @if ($content->photo_url)
                                                                    <a
                                                                        href="{{ $content->photo_url }}"
                                                                        target="_blank"
                                                                        rel="noopener"
                                                                        class="block overflow-hidden rounded-md border border-slate-200 bg-white"
                                                                    >
                                                                        <img
                                                                            src="{{ $content->photo_url }}"
                                                                            alt="Pratinjau foto {{ $content->title }}"
                                                                            class="h-32 w-full object-cover"
                                                                            loading="lazy"
                                                                        >
                                                                    </a>
                                                                @endif
                                                                <input class="form-input" type="file" id="file_{{ $content->id }}" name="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="material">
                                                                <label class="form-label text-xs" for="material_file_{{ $content->id }}">Dokumen Materi (opsional)</label>
                                                                @if ($content->document_url)
                                                                    @php
                                                                        $docSizeBytes = $content->document_size_bytes;
                                                                        $docSizeLabel = null;
                                                                        if ($docSizeBytes) {
                                                                            $docUnits = ['B', 'KB', 'MB', 'GB', 'TB'];
                                                                            $docSize = (float) $docSizeBytes;
                                                                            $docIndex = 0;
                                                                            while ($docSize >= 1024 && $docIndex < count($docUnits) - 1) {
                                                                                $docSize /= 1024;
                                                                                $docIndex++;
                                                                            }
                                                                            $docPrecision = $docIndex === 0 ? 0 : 1;
                                                                            $docFormatted = number_format($docSize, $docPrecision);
                                                                            $docFormatted = rtrim(rtrim($docFormatted, '0'), '.');
                                                                            $docSizeLabel = $docFormatted . ' ' . $docUnits[$docIndex];
                                                                        }
                                                                    @endphp
                                                                    <a
                                                                        href="{{ $content->document_url }}"
                                                                        target="_blank"
                                                                        rel="noopener"
                                                                        class="mb-2 inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-red-600 hover:text-red-600"
                                                                    >
                                                                        <span>Unduh {{ strtoupper($content->document_extension ?? 'Berkas') }}</span>
                                                                        @if ($docSizeLabel)
                                                                            <span class="text-red-600">({{ $docSizeLabel }})</span>
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                                <input class="form-input" type="file" id="material_file_{{ $content->id }}" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="narrative">
                                                                <label class="form-label text-xs" for="body_{{ $content->id }}">Konten Teks</label>
                                                                <textarea class="form-input" id="body_{{ $content->id }}" name="body" rows="4">{{ $content->body }}</textarea>
                                                            </div>

                                                            <button type="submit" class="primary-button w-full justify-center text-xs">
                                                                Perbarui
                                                            </button>
                                                        </form>
                                                    </div>
                                                </details>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td class="px-4 py-4 text-sm text-red-600" colspan="5">
                                                    Belum ada konten terdaftar.
                                                </td>
                                            </tr>
                                        @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($contents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">{{ $contents->withQueryString()->links() }}</div>
                    @endif
                    </section>
                </div>
            </section>
        </main>
    </div>

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

