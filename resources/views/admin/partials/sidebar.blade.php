@php
    $activeLink = $active ?? 'dashboard';
    $navLinks = [
        ['key' => 'dashboard', 'label' => 'Ringkasan', 'href' => route('admin.dashboard.ui')],
        ['key' => 'contents', 'label' => 'Konten Edukasi', 'href' => route('admin.contents.index')],
        ['key' => 'consultations', 'label' => 'Pengajuan Konsultasi', 'href' => route('admin.consultations.index')],
        ['key' => 'consultations_archive', 'label' => 'Arsip Konsultasi', 'href' => route('admin.consultations.archive')],
    ];
@endphp

<aside class="w-full rounded-2xl border border-slate-200 p-5 shadow-sm lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 lg:flex lg:h-screen lg:w-64 lg:flex-col lg:overflow-y-auto lg:rounded-none lg:border-0 lg:border-r lg:border-slate-200 lg:px-6 lg:py-10 lg:shadow-none xl:w-72" style="background-color: #feaaaa;">
 <!-- Header dengan logo dan branding -->
<div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-4">
    <img src="{{ asset('storage/logo/logotomohon.png') }}" 
         alt="Logo Posting Dasi" 
         class="w-12 h-12 object-contain">
    <div>
        <h1 class="text-lg font-bold text-slate-800">Admin Panel</h1>
        <p class="text-xs font-medium text-slate-500">Manajemen Sistem</p>
    </div>
</div>
    
    <p class="text-xs font-semibold uppercase tracking-wide text-red-600 mb-3 flex items-center gap-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
        </svg>
        Navigasi Admin
    </p>
    
    <nav class="mt-2 flex flex-col gap-2 text-sm font-medium text-slate-700 lg:flex-1" aria-label="Sections">
        @foreach ($navLinks as $link)
            @php($isActive = $activeLink === $link['key'])
            <a
                href="{{ $link['href'] }}"
                @class([
                    'flex items-center gap-3 rounded-xl px-3.5 py-3 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 group relative',
                    'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-md shadow-red-200 focus-visible:ring-red-500' => $isActive,
                    'text-slate-600 hover:bg-white hover:text-red-600 focus-visible:ring-red-500 hover:shadow-sm' => ! $isActive,
                ])
            >
                @if($isActive)
                <div class="absolute -left-2 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-red-500 rounded-full"></div>
                @endif
                
                <span class="inline-flex h-5 w-5 items-center justify-center text-current">
                    @switch($link['key'])
                        @case('dashboard')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            @break
                        @case('contents')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            @break
                        @case('consultations')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                            </svg>
                            @break
                        @case('consultations_archive')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            @break
                        @default
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                    @endswitch
                </span>
                <span class="font-medium">{{ $link['label'] }}</span>
                
                @if(!$isActive)
                <span class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="mt-6 border-t border-slate-200 pt-5 lg:mt-auto">
        <p class="text-xs font-semibold uppercase tracking-wide text-red-600 mb-3 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
            </svg>
            Aksi
        </p>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 hover:text-red-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                </svg>
                Keluar {{ auth()->user()?->name ? '('.auth()->user()->name.')' : '' }}
            </button>
        </form>
    </div>
</aside>
