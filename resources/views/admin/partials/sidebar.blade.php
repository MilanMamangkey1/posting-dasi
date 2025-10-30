@php
    $activeLink = $active ?? 'dashboard';
    $navLinks = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('admin.dashboard.ui'), 'icon' => '📊'],
        ['key' => 'contents', 'label' => 'Konten Edukasi', 'href' => route('admin.contents.index'), 'icon' => '📚'],
        ['key' => 'consultations', 'label' => 'Pengajuan Konsultasi', 'href' => route('admin.consultations.index'), 'icon' => '💬'],
    ];
@endphp

<style>
    .sidebar-container {
        background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #fed7d7;
        overflow: hidden;
    }
    
    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid #fed7d7;
        background: linear-gradient(135deg, #fef2f2 0%, #fed7d7 100%);
    }
    
    .sidebar-title {
        color: #c53030;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .sidebar-title::before {
        content: "🎀";
        font-size: 1.2rem;
    }
    
    .nav-section {
        padding: 1rem 1.5rem;
    }
    
    .nav-label {
        color: #718096;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-label::before {
        content: "";
        display: block;
        width: 4px;
        height: 12px;
        background-color: #c53030;
        border-radius: 2px;
    }
    
    .nav-links {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
        font-weight: 500;
        border: 1px solid transparent;
    }
    
    .nav-link:hover {
        background-color: #fed7d7;
        transform: translateX(4px);
    }
    
    .nav-link.active {
        background-color: #c53030;
        color: white;
        box-shadow: 0 4px 12px rgba(197, 48, 48, 0.3);
        border-color: #9b2c2c;
    }
    
    .nav-link.active .nav-icon {
        transform: scale(1.1);
    }
    
    .nav-icon {
        font-size: 1.1rem;
        transition: transform 0.2s ease;
    }
    
    .action-section {
        padding: 1rem 1.5rem;
        border-top: 1px solid #fed7d7;
        background-color: #fef2f2;
    }
    
    .logout-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #c53030 0%, #9b2c2c 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(197, 48, 48, 0.2);
    }
    
    .logout-button:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #7c1c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(197, 48, 48, 0.3);
    }
    
    .logout-button::before {
        content: "🚪";
        font-size: 1rem;
    }
    
    .user-info {
        font-size: 0.8rem;
        opacity: 0.9;
    }
</style>

<aside class="sidebar-container w-full lg:w-64">
    <div class="sidebar-header">
        <div class="sidebar-title">Posting Dasi Admin</div>
    </div>
    
    <div class="nav-section">
        <div class="nav-label">Navigasi Utama</div>
        <nav class="nav-links" aria-label="Sections">
            @foreach ($navLinks as $link)
                @php($isActive = $activeLink === $link['key'])
                <a
                    href="{{ $link['href'] }}"
                    class="nav-link {{ $isActive ? 'active' : '' }}"
                >
                    <span class="nav-icon">{{ $link['icon'] }}</span>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <div class="action-section">
        <div class="nav-label">Akun</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="logout-button">
                Keluar 
                @if(auth()->user()?->name)
                    <span class="user-info">({{ auth()->user()->name }})</span>
                @endif
            </button>
        </form>
    </div>
</aside>