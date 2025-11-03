@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('body')
   <header class="bg-white border-b border-slate-200 shadow-sm">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5">
        <div>
            <h1 class="flex items-center gap-3 text-2xl font-bold text-slate-900">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </span>
                Dashboard Admin Posting Dasi
            </h1>
            <p class="mt-1 text-sm text-slate-600">Kelola konten edukasi dan permintaan konsultasi dengan mudah.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Online
            </span>
            <span class="text-xs text-slate-500">Terakhir diperbarui {{ now()->translatedFormat('d M Y') }}</span>
        </div>
    </div>
</header>
    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row lg:items-start lg:gap-10">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

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

            <!-- Statistik Utama -->
            <section class="space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="flex items-center gap-3 text-xl font-bold text-slate-900">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                </svg>
                            </span>
                            Ringkasan Statistik
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">Tinjau metrik utama platform Posting Dasi</p>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Konten -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Total Konten</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $metrics['total_contents'] }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Akumulasi konten edukasi terdaftar</p>
                    </div>

                    <!-- Total Konsultasi -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Total Konsultasi</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $metrics['total_consultations'] }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Permintaan konsultasi yang masuk</p>
                    </div>

                    <!-- Distribusi Konten -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:col-span-2 lg:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Distribusi Konten</p>
                                <p class="text-lg font-bold text-slate-900">Per Jenis</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($metrics['contents_by_type'] as $type => $total)
                                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2">
                                    <span class="text-xs font-medium text-slate-700 uppercase">
                                        {{ $contentTypeLabels[$type] ?? ucfirst($type) }}
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">{{ $total }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status Konsultasi -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Status Konsultasi</p>
                            <p class="text-lg font-bold text-slate-900">Monitoring Layanan</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                        @foreach ($metrics['consultations_by_status'] as $status => $total)
                            <div class="flex flex-col items-center justify-center rounded-lg border border-slate-200 bg-white p-4 text-center">
                                <span class="text-xs font-medium text-slate-600 mb-2 uppercase">
                                    {{ $consultationStatusLabels[$status] ?? str_replace('_', ' ', $status) }}
                                </span>
                                <span class="text-xl font-bold text-slate-900">{{ $total }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Aktivitas Terbaru -->
            <section class="space-y-6">
                <h2 class="flex items-center gap-3 text-xl font-bold text-slate-900">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Aktivitas Terbaru
                </h2>

                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Konten Terbaru -->
                    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <header class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
                            <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-900">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Konten Terbaru
                            </h3>
                        </header>
                        <div class="p-6 space-y-4">
                            @forelse ($recentContents as $content)
                                <div class="flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-4 transition-all duration-200 hover:shadow-sm">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                        @if($content->type === 'video')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                        @elseif($content->type === 'photo')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-slate-900 truncate">{{ $content->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 uppercase">
                                                {{ $contentTypeLabels[$content->type] ?? ucfirst($content->type) }}
                                            </span>
                                            <span class="text-xs text-slate-500">{{ $content->updated_at->diffForHumans() }}</span>
                                        </div>
                                        @if ($content->photo_url)
                                            <a href="{{ $content->photo_url }}" target="_blank" rel="noopener" class="mt-2 block">
                                                <img src="{{ $content->photo_url }}" alt="Pratinjau {{ $content->title }}" class="h-20 w-full rounded-lg object-cover border border-slate-200">
                                            </a>
                                        @elseif ($content->document_url)
                                            <a href="{{ $content->document_url }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Unduh Dokumen
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-slate-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="mt-2 text-sm">Belum ada konten terdaftar</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">
                            <a href="{{ route('admin.contents.index') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200">
                                <span>Kelola Semua Konten</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </section>

                    <!-- Konsultasi Terbaru -->
                    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <header class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
                            <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-900">
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Konsultasi Terbaru
                            </h3>
                        </header>
                        <div class="p-6 space-y-4">
                            @forelse ($recentConsultations as $consultation)
                                <div class="flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-4 transition-all duration-200 hover:shadow-sm">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10c0-1.777.833-3.363 2.136-4.419A5 5 0 0010 11z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-slate-900">{{ $consultation->full_name }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-amber-50 text-amber-700',
                                                    'approved' => 'bg-green-50 text-green-700',
                                                    'rejected' => 'bg-red-50 text-red-700',
                                                    'completed' => 'bg-blue-50 text-blue-700'
                                                ];
                                                $statusColor = $statusColors[$consultation->status] ?? 'bg-slate-50 text-slate-700';
                                            @endphp
                                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium uppercase {{ $statusColor }}">
                                                {{ $consultationStatusLabels[$consultation->status] ?? str_replace('_', ' ', $consultation->status) }}
                                            </span>
                                            <span class="text-xs text-slate-500">{{ $consultation->updated_at->diffForHumans() }}</span>
                                        </div>
                                        @if($consultation->email)
                                            <p class="text-xs text-slate-600 mt-1">{{ $consultation->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-slate-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="mt-2 text-sm">Belum ada pengajuan konsultasi</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">
                            <a href="{{ route('admin.consultations.index') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200">
                                <span>Kelola Semua Konsultasi</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>
@endsection