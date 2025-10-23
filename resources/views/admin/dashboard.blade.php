@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('body')
    <header class="bg-white/90 shadow-sm border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Website Posting Dasi &mdash; Backend Admin</h1>
                <p class="text-sm text-slate-500">
                    Kelola konten edukasi dan permintaan konsultasi sesuai alur kerja backend.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <nav class="flex flex-wrap gap-2" aria-label="Admin sections">
                    <button
                        type="button"
                        class="section-tab rounded-lg border border-transparent bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900"
                        data-target-section="dashboard"
                    >
                        Dashboard
                    </button>
                    <button
                        type="button"
                        class="section-tab rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-slate-300 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900"
                        data-target-section="contents"
                    >
                        Konten Edukasi
                    </button>
                    <button
                        type="button"
                        class="section-tab rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-slate-300 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900"
                        data-target-section="consultations"
                    >
                        Pengajuan Konsultasi
                    </button>
                </nav>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="secondary-button">
                        Keluar {{ auth()->user()?->name ? '('.auth()->user()->name.')' : '' }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main id="admin-main" class="mx-auto max-w-7xl space-y-10 px-6 py-8">
        <section
            id="section-dashboard"
            data-section="dashboard"
            class="space-y-8"
        >
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" id="metric-cards">
                <article class="metric-card">
                    <div class="metric-card__body">
                        <dt>Total Konten</dt>
                        <dd data-metric="total_contents">-</dd>
                    </div>
                    <p class="metric-card__hint">Akumulasi semua jenis konten edukasi.</p>
                </article>
                <article class="metric-card">
                    <div class="metric-card__body">
                        <dt>Total Pengajuan Konsultasi</dt>
                        <dd data-metric="total_consultations">-</dd>
                    </div>
                    <p class="metric-card__hint">Jumlah seluruh pengajuan dari pengguna publik.</p>
                </article>
                <article class="metric-card">
                    <div class="metric-card__body">
                        <dt>Konten Per Jenis</dt>
                        <dd
                            class="text-xs font-medium text-slate-500"
                            data-metric="contents_by_type"
                        >
                            -
                        </dd>
                    </div>
                    <p class="metric-card__hint">Distribusi berdasarkan tipe (video, gambar, dsb).</p>
                </article>
                <article class="metric-card">
                    <div class="metric-card__body">
                        <dt>Konsultasi Per Status</dt>
                        <dd
                            class="text-xs font-medium text-slate-500"
                            data-metric="consultations_by_status"
                        >
                            -
                        </dd>
                    </div>
                    <p class="metric-card__hint">Ikuti perkembangan antrian konsultasi backend.</p>
                </article>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <section class="panel">
                    <header class="panel__header">
                        <h2>Konten Edukasi Terbaru</h2>
                        <button type="button" class="refresh-button" data-refresh="contents">
                            Muat ulang
                        </button>
                    </header>
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-4 py-3 text-left">Judul</th>
                                    <th class="px-4 py-3 text-left">Jenis</th>
                                    <th class="px-4 py-3 text-left">Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody id="recent-contents" class="divide-y divide-slate-200">
                                <tr>
                                    <td class="px-4 py-4 text-sm text-slate-500" colspan="3">
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel__header">
                        <h2>Pengajuan Konsultasi Terbaru</h2>
                        <button type="button" class="refresh-button" data-refresh="consultations">
                            Muat ulang
                        </button>
                    </header>
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-4 py-3 text-left">Nama</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody id="recent-consultations" class="divide-y divide-slate-200">
                                <tr>
                                    <td class="px-4 py-4 text-sm text-slate-500" colspan="3">
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </section>

        <section
            id="section-contents"
            data-section="contents"
            class="space-y-8 hidden"
        >
            <section class="panel">
                <header class="panel__header">
                    <div>
                        <h2>Form Konten Edukasi</h2>
                        <p class="panel__sub">Ikuti aturan validasi sesuai flow backend.</p>
                    </div>
                    <button type="button" class="secondary-button" data-action="reset-content-form">
                        Reset Form
                    </button>
                </header>
                <form id="content-form" class="space-y-5" enctype="multipart/form-data">
                    <input type="hidden" name="content_id" id="content-id">
                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="form-field">
                            <span>Judul <sup class="text-rose-500">*</sup></span>
                            <input
                                type="text"
                                name="title"
                                id="content-title"
                                required
                                class="form-input"
                                placeholder="Contoh: Edukasi Nutrisi Ibu & Anak"
                            >
                        </label>
                        <label class="form-field">
                            <span>Jenis Konten <sup class="text-rose-500">*</sup></span>
                            <select
                                name="type"
                                id="content-type"
                                required
                                class="form-input"
                            >
                                <option value="">Pilih jenis</option>
                                <option value="video">Video (YouTube)</option>
                                <option value="photo">Foto</option>
                                <option value="narrative">Narasi</option>
                                <option value="material">Materi</option>
                            </select>
                        </label>
                    </div>
                    <label class="form-field">
                        <span>Ringkasan</span>
                        <textarea
                            name="summary"
                            id="content-summary"
                            rows="3"
                            class="form-input"
                            placeholder="Ringkas tujuan konten untuk memudahkan kurasi."
                        ></textarea>
                    </label>
                    <div class="grid gap-5 md:grid-cols-2" id="type-specific-fields">
                        <label class="form-field hidden" data-field-for="video">
                            <span>Tautan YouTube <sup class="text-rose-500">*</sup></span>
                            <input
                                type="url"
                                name="source_url"
                                id="content-source-url"
                                class="form-input"
                                placeholder="https://www.youtube.com/watch?v=XXXXXXXXXXX"
                            >
                            <p class="form-hint">Hanya tautan youtube.com atau youtu.be yang diterima.</p>
                        </label>
                        <label class="form-field hidden" data-field-for="photo">
                            <span>Unggah Foto <sup class="text-rose-500">*</sup></span>
                            <input
                                type="file"
                                name="file"
                                id="content-photo-file"
                                accept=".jpg,.jpeg,.png,.gif,.webp"
                                class="form-input"
                            >
                            <p class="form-hint">Maksimal 5 MB per foto.</p>
                        </label>
                        <label class="form-field hidden md:col-span-2" data-field-for="narrative material">
                            <span>Isi Konten <sup class="text-rose-500">*</sup></span>
                            <textarea
                                name="body"
                                id="content-body"
                                rows="5"
                                class="form-input"
                                placeholder="Tulis narasi atau materi edukasi di sini."
                            ></textarea>
                        </label>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-sm text-slate-500">
                            Layanan backend otomatis menyimpan berkas foto atau tautan video sesuai jenis konten.
                        </p>
                        <div class="flex gap-3">
                            <button type="submit" class="primary-button">
                                Simpan Konten
                            </button>
                        </div>
                    </div>
                    <div
                        id="content-form-feedback"
                        class="rounded-lg border border-transparent bg-emerald-50 px-4 py-3 text-sm text-emerald-700 hidden"
                        role="status"
                    ></div>
                    <div
                        id="content-form-errors"
                        class="rounded-lg border border-transparent bg-rose-50 px-4 py-3 text-sm text-rose-700 hidden"
                        role="alert"
                    ></div>
                </form>
            </section>

            <section class="panel">
                <header class="panel__header">
                    <div>
                        <h2>Daftar Konten Edukasi</h2>
                        <p class="panel__sub">Filter berdasarkan jenis atau kata kunci judul.</p>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <label class="sr-only" for="content-filter-type">Filter jenis</label>
                        <select id="content-filter-type" class="form-input w-full sm:w-auto">
                            <option value="">Semua jenis</option>
                            <option value="video">Video</option>
                            <option value="image">Gambar</option>
                            <option value="narrative">Narasi</option>
                            <option value="material">Materi</option>
                        </select>
                        <label class="sr-only" for="content-filter-search">Cari</label>
                        <input
                            type="search"
                            id="content-filter-search"
                            class="form-input w-full sm:w-56"
                            placeholder="Cari judul konten..."
                        >
                        <button type="button" class="secondary-button" data-action="refresh-content-list">
                            Terapkan
                        </button>
                    </div>
                </header>
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Judul</th>
                                <th class="px-4 py-3 text-left">Jenis</th>
                                <th class="px-4 py-3 text-left">Terbit</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="content-table-body" class="divide-y divide-slate-200">
                            <tr>
                                <td class="px-4 py-4 text-sm text-slate-500" colspan="4">
                                    Belum ada data.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>

        <section
            id="section-consultations"
            data-section="consultations"
            class="space-y-8 hidden"
        >
            <section class="panel">
                <header class="panel__header">
                    <div>
                        <h2>Antrian Pengajuan Konsultasi</h2>
                        <p class="panel__sub">Hubungi cepat via WhatsApp dan kelola status pengajuan.</p>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <label class="sr-only" for="consultation-filter-status">Filter status</label>
                        <select id="consultation-filter-status" class="form-input w-full sm:w-auto">
                            <option value="">Semua status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">Sedang diproses</option>
                            <option value="resolved">Selesai</option>
                            <option value="archived">Arsip</option>
                        </select>
                        <label class="sr-only" for="consultation-filter-search">Cari</label>
                        <input
                            type="search"
                            id="consultation-filter-search"
                            class="form-input w-full sm:w-56"
                            placeholder="Cari nama atau nomor WhatsApp"
                        >
                        <button type="button" class="secondary-button" data-action="refresh-consultation-list">
                            Terapkan
                        </button>
                    </div>
                </header>
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
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
                        <tbody id="consultation-table-body" class="divide-y divide-slate-200">
                            <tr>
                                <td class="px-4 py-4 text-sm text-slate-500" colspan="5">
                                    Belum ada data.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </section>
    </main>
@endsection
