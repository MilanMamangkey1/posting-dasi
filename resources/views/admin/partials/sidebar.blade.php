@php
    $activeLink = $active ?? 'dashboard';
    $navLinks = [
        ['key' => 'dashboard', 'label' => 'Ringkasan', 'href' => route('admin.dashboard.ui')],
        ['key' => 'contents', 'label' => 'Konten Edukasi', 'href' => route('admin.contents.index')],
        ['key' => 'consultations', 'label' => 'Pengajuan Konsultasi', 'href' => route('admin.consultations.index')],
    ];
@endphp

<aside class="w-full rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:w-64">
    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Navigasi Admin</p>
    <nav class="mt-4 flex flex-col gap-2 text-sm font-medium text-slate-700" aria-label="Sections">
        @foreach ($navLinks as $link)
            @php($isActive = $activeLink === $link['key'])
            <a
                href="{{ $link['href'] }}"
                @class([
                    'rounded-xl border px-4 py-2 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
                    'border-slate-900 bg-slate-900 text-white focus-visible:ring-slate-900' => $isActive,
                    'border-slate-200 hover:border-slate-400 hover:text-slate-900 focus-visible:ring-slate-300' => ! $isActive,
                ])
            >
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="mt-6 border-t border-slate-100 pt-6">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="secondary-button w-full justify-center">
                Keluar {{ auth()->user()?->name ? '('.auth()->user()->name.')' : '' }}
            </button>
        </form>
    </div>
</aside>
