@php
    $activeLink = $active ?? 'dashboard';
    $navLinks = [
        ['key' => 'dashboard', 'label' => 'Ringkasan', 'href' => route('admin.dashboard.ui')],
        ['key' => 'contents', 'label' => 'Konten Edukasi', 'href' => route('admin.contents.index')],
        ['key' => 'consultations', 'label' => 'Pengajuan Konsultasi', 'href' => route('admin.consultations.index')],
        ['key' => 'consultations_archive', 'label' => 'Arsip Konsultasi', 'href' => route('admin.consultations.archive')],
    ];
@endphp

<aside class="w-full rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 lg:flex lg:h-screen lg:w-64 lg:flex-col lg:overflow-y-auto lg:rounded-none lg:border-0 lg:border-r lg:border-slate-200 lg:px-6 lg:py-10 lg:shadow-none xl:w-72">
    <p class="text-xs font-semibold uppercase tracking-wide text-red-600">Navigasi Admin</p>
    <nav class="mt-4 flex flex-col gap-1.5 text-sm font-medium text-slate-700 lg:flex-1" aria-label="Sections">
        @foreach ($navLinks as $link)
            @php($isActive = $activeLink === $link['key'])
            <a
                href="{{ $link['href'] }}"
                @class([
                    'flex items-center gap-3 rounded-xl border px-3.5 py-2 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
                    'border-red-600 bg-red-600 text-white focus-visible:ring-red-600' => $isActive,
                    'border-slate-200 text-slate-600 hover:border-slate-300 hover:text-red-600 focus-visible:ring-red-600' => ! $isActive,
                ])
            >
                <span class="inline-flex h-5 w-5 items-center justify-center text-current">
                    @switch($link['key'])
                        @case('dashboard')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3l8.25 6v12H3.75V9z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 21V12h4.5v9" />
                            </svg>
                            @break
                        @case('contents')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 6h15M7.5 10.5h9m-9 4.5h6M6 3h12a1.5 1.5 0 011.5 1.5v15A1.5 1.5 0 0118 21H6a1.5 1.5 0 01-1.5-1.5v-15A1.5 1.5 0 016 3z" />
                            </svg>
                            @break
                        @case('consultations')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 8.25h9m-9 3h6M2.25 12a8.25 8.25 0 1115.573 4.032l1.32 3.3a.75.75 0 01-.966.966l-3.3-1.32A8.25 8.25 0 012.25 12z" />
                            </svg>
                            @break
                        @case('consultations_archive')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 6.75h15M6 9h12l-.75 10.125a1.5 1.5 0 01-1.494 1.375H8.244a1.5 1.5 0 01-1.494-1.375L6 9zM9.75 9V6a2.25 2.25 0 012.25-2.25A2.25 2.25 0 0114.25 6v3" />
                            </svg>
                            @break
                        @default
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                            </svg>
                    @endswitch
                </span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-6 border-t border-slate-200 pt-5 lg:mt-auto">
        <p class="text-xs font-semibold uppercase tracking-wide text-red-600">Aksi</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="secondary-button w-full justify-center">
                Keluar {{ auth()->user()?->name ? '('.auth()->user()->name.')' : '' }}
            </button>
        </form>
    </div>
</aside>
