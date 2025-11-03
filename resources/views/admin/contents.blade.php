@extends('layouts.admin')

@section('title', 'Kelola Konten Edukasi')

@section('body')
    <header class="bg-white border-b border-slate-200 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-bold text-slate-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Kelola Konten Edukasi
                </h1>
                <p class="mt-1 text-sm text-slate-600">Tambahkan video, foto, narasi, dan materi edukasi langsung dari area admin.</p>
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
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-3 text-xl font-bold text-slate-900">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Kelola Konten Edukasi
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Gunakan penyaringan untuk menampilkan konten berdasarkan jenis atau judul.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.contents.index') }}" class="flex flex-wrap items-end gap-4 text-sm text-slate-700">
                        <div class="flex flex-col">
                            <label for="content_type" class="text-xs font-semibold uppercase tracking-wide text-red-600 mb-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Jenis
                            </label>
                            <select id="content_type" name="content_type" class="form-input w-48 rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200">
                                <option value="">Semua jenis</option>
                                @foreach ($contentTypes as $type)
                                    <option value="{{ $type }}" @selected($contentFilters['type'] === $type)>{{ $contentTypeLabels[$type] ?? ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="content_search" class="text-xs font-semibold uppercase tracking-wide text-red-600 mb-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                                Cari judul
                            </label>
                            <input id="content_search" type="search" name="content_search" value="{{ $contentFilters['search'] }}" class="form-input w-72 rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" placeholder="Cari judul konten">
                        </div>
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Terapkan Penyaringan
                        </button>
                    </form>
                </div>

                <div class="space-y-8">
                    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <header class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
                            <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-900">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Tambah Konten Edukasi
                            </h3>
                        </header>
                        <form method="POST" action="{{ route('admin.contents.store') }}" enctype="multipart/form-data" class="space-y-6 p-6" data-content-form>
                            @csrf
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="title">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                                        </svg>
                                        Judul
                                    </label>
                                    <input class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" type="text" id="title" name="title" value="{{ old('title') }}" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="type">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Jenis Konten
                                    </label>
                                    <select class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" id="type" name="type" data-field-control="type" required>
                                        <option value="">Pilih jenis konten</option>
                                        @foreach ($contentTypes as $type)
                                            <option value="{{ $type }}" @selected(old('type') === $type)>{{ $contentTypeLabels[$type] ?? ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="summary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Ringkasan Singkat
                                </label>
                                <textarea class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" id="summary" name="summary" rows="2">{{ old('summary') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="event_date">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Tanggal Kegiatan (opsional)
                                </label>
                                <input
                                    class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200"
                                    type="date"
                                    id="event_date"
                                    name="event_date"
                                    value="{{ old('event_date') }}"
                                >
                                <p class="text-xs text-slate-500 mt-1">Isi tanggal kegiatan berlangsung atau biarkan kosong bila tidak diperlukan.</p>
                            </div>

                            <div class="space-y-2" data-field-for="video">
                                <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="source_url">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    </svg>
                                    Tautan Video YouTube
                                </label>
                                <input class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" type="url" id="source_url" name="source_url" value="{{ old('source_url') }}">
                            </div>

                            <div class="space-y-2" data-field-for="photo">
                                <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="file">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                    Foto (maksimal 3 MB)
                                </label>
                                <input class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" type="file" id="file" name="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                            </div>

                            <div class="space-y-2" data-field-for="material">
                                <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="material_file">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    Dokumen Materi (PDF, DOCX, PPTX &le; 3 MB)
                                </label>
                                <input class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" type="file" id="material_file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            </div>

                            <div class="space-y-2" data-field-for="narrative">
                                <label class="form-label flex items-center gap-1.5 font-medium text-slate-700" for="body">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                    </svg>
                                    Konten Teks
                                </label>
                                <textarea class="form-input rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 transition-colors duration-200" id="body" name="body" rows="5">{{ old('body') }}</textarea>
                            </div>

                            <button type="submit" class="flex items-center justify-center gap-2 w-full md:w-auto px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Simpan Konten
                            </button>
                        </form>
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <header class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
                            <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-900">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                                        <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                    </svg>
                                </span>
                                Konten Terdaftar
                            </h3>
                        </header>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-700">
                                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase text-red-600">
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
                                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                                            <td class="px-4 py-4 font-medium text-slate-900">
                                                {{ $content->title }}
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 uppercase">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $contentTypeLabels[$content->type] ?? ucfirst($content->type) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-slate-600">
                                                <div class="max-w-xs truncate">{{ $content->summary ?? '-' }}</div>
                                                @if ($content->photo_url)
                                                    <a
                                                        href="{{ $content->photo_url }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="mt-3 inline-block overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md"
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
                                                        class="mt-3 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:border-red-300 hover:bg-red-50 hover:text-red-700 hover:shadow-sm"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span>Unduh {{ strtoupper($content->document_extension ?? 'Berkas') }}</span>
                                                        @if ($listDocLabel)
                                                            <span class="text-red-600">({{ $listDocLabel }})</span>
                                                        @endif
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-sm text-slate-500 whitespace-nowrap">
                                                @php
                                                    $uploadedAt = optional($content->event_date ?? $content->created_at)->format('d/m/Y');
                                                @endphp
                                                {{ $uploadedAt ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <details class="inline-block text-left">
                                                    <summary class="cursor-pointer flex items-center gap-1 text-xs font-semibold text-red-600 hover:text-red-700 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                        </svg>
                                                        Kelola
                                                    </summary>
                                                    <div class="mt-2 space-y-4 rounded-xl border border-slate-200 bg-white p-4 shadow-lg absolute z-10 w-80 right-4">
                                                        <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('Hapus konten ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="flex items-center justify-center gap-2 w-full px-3 py-2 text-xs font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </form>

                                                        <form method="POST" action="{{ route('admin.contents.update', $content) }}" enctype="multipart/form-data" class="space-y-3" data-content-form>
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="type" value="{{ $content->type }}" data-field-control="type">
                                                            <div class="space-y-1">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="title_{{ $content->id }}">Judul</label>
                                                                <input class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" type="text" id="title_{{ $content->id }}" name="title" value="{{ $content->title }}" required>
                                                            </div>
                                                            <div class="space-y-1">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="summary_{{ $content->id }}">Ringkasan</label>
                                                                <textarea class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" id="summary_{{ $content->id }}" name="summary" rows="2">{{ $content->summary }}</textarea>
                                                            </div>

                                                            <div class="space-y-1">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="event_date_{{ $content->id }}">Tanggal Kegiatan</label>
                                                                <input
                                                                    class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                                                                    type="date"
                                                                    id="event_date_{{ $content->id }}"
                                                                    name="event_date"
                                                                    value="{{ old('event_date', optional($content->event_date)->format('Y-m-d')) }}"
                                                                >
                                                            </div>

                                                            <!-- Field groups for different content types -->
                                                            <div class="space-y-1" data-field-for="video">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="source_url_{{ $content->id }}">Tautan Video</label>
                                                                <input class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" type="url" id="source_url_{{ $content->id }}" name="source_url" value="{{ $content->source_url }}">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="photo">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="file_{{ $content->id }}">Foto</label>
                                                                @if ($content->photo_url)
                                                                    <a
                                                                        href="{{ $content->photo_url }}"
                                                                        target="_blank"
                                                                        rel="noopener"
                                                                        class="block overflow-hidden rounded-lg border border-slate-200 bg-white mb-2"
                                                                    >
                                                                        <img
                                                                            src="{{ $content->photo_url }}"
                                                                            alt="Pratinjau foto {{ $content->title }}"
                                                                            class="h-24 w-full object-cover"
                                                                            loading="lazy"
                                                                        >
                                                                    </a>
                                                                @endif
                                                                <input class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" type="file" id="file_{{ $content->id }}" name="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="material">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="material_file_{{ $content->id }}">Dokumen</label>
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
                                                                        class="mb-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-xs font-medium text-red-600 transition-all duration-200 hover:border-red-300 hover:bg-red-50"
                                                                    >
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        <span>Unduh {{ strtoupper($content->document_extension ?? 'Berkas') }}</span>
                                                                        @if ($docSizeLabel)
                                                                            <span class="text-red-600">({{ $docSizeLabel }})</span>
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                                <input class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" type="file" id="material_file_{{ $content->id }}" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="narrative">
                                                                <label class="form-label text-xs font-medium text-slate-700" for="body_{{ $content->id }}">Konten Teks</label>
                                                                <textarea class="form-input text-xs rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500" id="body_{{ $content->id }}" name="body" rows="3">{{ $content->body }}</textarea>
                                                            </div>

                                                            <button type="submit" class="flex items-center justify-center gap-2 w-full px-3 py-2 text-xs font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                </svg>
                                                                Perbarui
                                                            </button>
                                                        </form>
                                                    </div>
                                                </details>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-8 text-center text-sm text-slate-500" colspan="5">
                                                <div class="flex flex-col items-center justify-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="font-medium text-slate-600">Belum ada konten terdaftar.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($contents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                                {{ $contents->withQueryString()->links() }}
                            </div>
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