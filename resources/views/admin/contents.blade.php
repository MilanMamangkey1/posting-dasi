@extends('layouts.admin')

@section('title', 'Kelola Konten Edukasi')

@section('body')
    <header class="bg-white/90 border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Kelola Konten Edukasi</h1>
                <p class="text-sm text-slate-500">Tambahkan video, foto, narasi, dan materi edukasi langsung dari backend.</p>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row">
        @include('admin.partials.sidebar', ['active' => 'contents'])

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
                        <h2 class="text-xl font-semibold text-slate-900">Kelola Konten Edukasi</h2>
                        <p class="text-sm text-slate-500">Gunakan filter untuk menyaring konten berdasarkan jenis atau judul.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.contents.index') }}" class="flex flex-wrap items-end gap-3 text-sm text-slate-700">
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
                            <input id="content_search" type="search" name="content_search" value="{{ $contentFilters['search'] }}" class="form-input w-72" placeholder="Cari judul konten">
                        </div>
                        <button type="submit" class="secondary-button">Terapkan Filter</button>
                    </form>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <section class="panel">
                        <header class="panel__header">
                            <h3>Tambah Konten Edukasi</h3>
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
                                        <option value="{{ $type }}" @selected(old('type') === $type)>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="form-label" for="summary">Ringkasan Singkat</label>
                                <textarea class="form-input" id="summary" name="summary" rows="2">{{ old('summary') }}</textarea>
                            </div>

                            <div class="space-y-1" data-field-for="video">
                                <label class="form-label" for="source_url">URL Video YouTube</label>
                                <input class="form-input" type="url" id="source_url" name="source_url" value="{{ old('source_url') }}">
                            </div>

                            <div class="space-y-1" data-field-for="photo">
                                <label class="form-label" for="file">Foto (maksimal 5 MB)</label>
                                <input class="form-input" type="file" id="file" name="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                            </div>

                            <div class="space-y-1" data-field-for="narrative material">
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
                            <h3>Konten Terdaftar</h3>
                        </header>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-600">
                                <thead class="border-b border-slate-200 text-xs font-semibold uppercase text-slate-500">
                                    <tr>
                                        <th class="px-3 py-2">Judul</th>
                                        <th class="px-3 py-2">Jenis</th>
                                        <th class="px-3 py-2">Ringkasan</th>
                                        <th class="px-3 py-2 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($contents as $content)
                                        <tr>
                                            <td class="px-3 py-3 font-medium text-slate-900">
                                                {{ $content->title }}
                                            </td>
                                            <td class="px-3 py-3 uppercase text-xs text-slate-500">{{ $content->type }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $content->summary ?? '-' }}</td>
                                            <td class="px-3 py-3 text-right">
                                                <details class="inline-block text-left">
                                                    <summary class="cursor-pointer text-xs font-semibold text-slate-500 hover:text-slate-900">
                                                        Kelola
                                                    </summary>
                                                    <div class="mt-2 space-y-2 rounded-lg border border-slate-200 bg-white p-3 shadow-lg">
                                                        <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('Hapus konten ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="danger-button w-full justify-center text-xs">Hapus</button>
                                                        </form>

                                                        <form method="POST" action="{{ route('admin.contents.update', $content) }}" enctype="multipart/form-data" class="mt-4 space-y-3" data-content-form>
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

                                                            <div class="space-y-1" data-field-for="video">
                                                                <label class="form-label text-xs" for="source_url_{{ $content->id }}">URL Video YouTube</label>
                                                                <input class="form-input" type="url" id="source_url_{{ $content->id }}" name="source_url" value="{{ $content->source_url }}">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="photo">
                                                                <label class="form-label text-xs" for="file_{{ $content->id }}">Foto (opsional)</label>
                                                                <input class="form-input" type="file" id="file_{{ $content->id }}" name="file" accept=".jpg,.jpeg,.png,.gif,.webp">
                                                            </div>

                                                            <div class="space-y-1" data-field-for="narrative material">
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
                                            <td class="px-3 py-4 text-sm text-slate-500" colspan="4">
                                                Belum ada konten terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
