@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('body')
    <style>
        :root {
            --primary-red: #DC2626;
            --primary-red-dark: #B91C1C;
            --primary-red-light: #EF4444;
            --accent-red: #FEE2E2;
            --accent-red-dark: #FECACA;
            --neutral-50: #F9FAFB;
            --neutral-100: #F3F4F6;
            --neutral-200: #E5E7EB;
            --neutral-300: #D1D5DB;
            --neutral-600: #4B5563;
            --neutral-700: #374151;
            --neutral-800: #1F2937;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            background: var(--neutral-50);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header-title {
            color: white;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0;
        }
        
        .header-logo {
            width: 3.5rem;
            height: 3.5rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .header-text h1 {
            font-size: 1.75rem;
            margin: 0;
            letter-spacing: -0.02em;
        }
        
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            margin-top: 0.25rem;
            font-weight: 400;
        }
        
        .status-success {
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            border-left: 4px solid #10B981;
            color: #065F46;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-md);
        }
        
        .status-success::before {
            content: '✓';
            width: 2rem;
            height: 2rem;
            background: #10B981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        
        .status-error {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            border-left: 4px solid var(--primary-red);
            color: var(--primary-red-dark);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-md);
        }
        
        .status-error::before {
            content: '✕';
            width: 2rem;
            height: 2rem;
            background: var(--primary-red);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .section-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: var(--shadow-md);
        }
        
        .section-title {
            color: var(--neutral-800);
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -0.02em;
        }
        
        .section-subtitle {
            color: var(--neutral-600);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            margin-top: 0.25rem;
        }
        
        .last-updated {
            background: white;
            color: var(--primary-red);
            padding: 0.625rem 1.25rem;
            border-radius: 24px;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--neutral-200);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .last-updated-icon {
            animation: rotate 2s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .metric-card {
            background: white;
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--neutral-200);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-red) 0%, var(--primary-red-light) 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        
        .metric-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--accent-red-dark);
        }
        
        .metric-card:hover::before {
            transform: scaleX(1);
        }
        
        .metric-card__body {
            margin-bottom: 1rem;
        }
        
        .metric-card dt {
            color: var(--neutral-600);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .metric-icon {
            width: 1.5rem;
            height: 1.5rem;
            background: var(--accent-red);
            color: var(--primary-red);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }
        
        .metric-card dd {
            color: var(--primary-red);
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.02em;
        }
        
        .metric-card__hint {
            color: var(--neutral-600);
            font-size: 0.875rem;
            border-top: 1px solid var(--neutral-200);
            padding-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .metric-card__hint::before {
            content: 'ℹ️';
            font-size: 0.875rem;
        }
        
        .type-badge {
            background: linear-gradient(135deg, var(--accent-red) 0%, var(--accent-red-dark) 100%);
            color: var(--primary-red);
            padding: 0.375rem 0.875rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            border: 1px solid var(--accent-red-dark);
            letter-spacing: 0.03em;
        }
        
        .status-badge {
            background: linear-gradient(135deg, var(--accent-red) 0%, var(--accent-red-dark) 100%);
            color: var(--primary-red);
            padding: 0.375rem 0.875rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            border: 1px solid var(--accent-red-dark);
            letter-spacing: 0.03em;
        }
        
        .panel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 1rem;
        }
        
        .panel {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--neutral-200);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .panel:hover {
            box-shadow: var(--shadow-xl);
        }
        
        .panel__header {
            background: linear-gradient(135deg, var(--neutral-50) 0%, white 100%);
            padding: 1.5rem;
            border-bottom: 1px solid var(--neutral-200);
        }
        
        .panel__header h3 {
            color: var(--neutral-800);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
            font-size: 1.125rem;
        }
        
        .panel-icon {
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }
        
        .activity-list {
            padding: 1.5rem;
            max-height: 500px;
            overflow-y: auto;
        }
        
        .activity-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .activity-list::-webkit-scrollbar-track {
            background: var(--neutral-100);
        }
        
        .activity-list::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 3px;
        }
        
        .activity-item {
            background: var(--neutral-50);
            border: 1px solid var(--neutral-200);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .activity-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary-red);
            border-radius: 12px 0 0 12px;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .activity-item:hover {
            border-color: var(--accent-red-dark);
            background: white;
            transform: translateX(8px);
            box-shadow: var(--shadow-md);
        }
        
        .activity-item:hover::before {
            transform: scaleY(1);
        }
        
        .activity-item:last-child {
            margin-bottom: 0;
        }
        
        .activity-title {
            color: var(--neutral-800);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 1rem;
            line-height: 1.4;
        }
        
        .activity-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.625rem;
            margin-bottom: 0.875rem;
        }
        
        .activity-time {
            color: var(--neutral-600);
            font-size: 0.8125rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .preview-image {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--neutral-200);
            margin-top: 1rem;
            box-shadow: var(--shadow-sm);
        }
        
        .preview-image img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .preview-image:hover img {
            transform: scale(1.08);
        }
        
        .download-link {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            margin-top: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
        }
        
        .download-link:hover {
            background: linear-gradient(135deg, var(--primary-red-dark) 0%, #991B1B 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .accent-link {
            color: var(--primary-red);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9375rem;
        }
        
        .accent-link:hover {
            color: var(--primary-red-dark);
            gap: 0.75rem;
        }
        
        .accent-link span {
            transition: transform 0.3s ease;
        }
        
        .accent-link:hover span {
            transform: translateX(4px);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--neutral-600);
            font-weight: 500;
        }
        
        .empty-state::before {
            content: '📋';
            font-size: 3rem;
            display: block;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .header-logo {
                width: 3rem;
                height: 3rem;
                font-size: 1.5rem;
            }
            
            .header-text h1 {
                font-size: 1.5rem;
            }
            
            .section-title {
                font-size: 1.25rem;
            }
            
            .metric-card dd {
                font-size: 1.875rem;
            }
            
            .panel-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <header class="dashboard-header">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-6 header-content">
            <div class="header-title">
                <div class="header-logo">🎀</div>
                <div class="header-text">
                    <h1>Posting Dasi</h1>
                    <p class="header-subtitle">
                        Dashboard Admin — Kelola konten dan konsultasi dengan mudah
                    </p>
                </div>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:flex-row">
        @include('admin.partials.sidebar', ['active' => 'dashboard'])

        <main class="flex-1 space-y-12">
            @if ($statusMessage)
                <div class="status-success">
                    {{ $statusMessage }}
                </div>
            @endif

            @if ($statusError)
                <div class="status-error">
                    {{ $statusError }}
                </div>
            @endif

            <section id="metrics" class="space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="section-header">
                            <div class="section-icon">📊</div>
                            <h2 class="section-title">Ringkasan Data</h2>
                        </div>
                        <p class="section-subtitle">Pantau metrik inti Posting Dasi secara real-time</p>
                    </div>
                    <div class="last-updated">
                        <span class="last-updated-icon">🔄</span>
                        Terakhir diperbarui {{ now()->translatedFormat('d M Y, H:i') }}
                    </div>
                </div>
                
                <div class="metric-grid">
                    <article class="metric-card">
                        <div class="metric-card__body">
                            <dt><span class="metric-icon">📚</span> Total Konten</dt>
                            <dd>{{ $metrics['total_contents'] }}</dd>
                        </div>
                        <p class="metric-card__hint">Akumulasi konten edukasi terdaftar</p>
                    </article>
                    
                    <article class="metric-card">
                        <div class="metric-card__body">
                            <dt><span class="metric-icon">💬</span> Total Konsultasi</dt>
                            <dd>{{ $metrics['total_consultations'] }}</dd>
                        </div>
                        <p class="metric-card__hint">Jumlah permintaan konsultasi yang masuk</p>
                    </article>
                    
                    <article class="metric-card">
                        <div class="metric-card__body">
                            <dt><span class="metric-icon">📦</span> Konten per Jenis</dt>
                            <dd>
                                @foreach ($metrics['contents_by_type'] as $type => $total)
                                    <span class="type-badge">{{ $contentTypeLabels[$type] ?? ucfirst($type) }}: {{ $total }}</span>
                                @endforeach
                            </dd>
                        </div>
                        <p class="metric-card__hint">Distribusi video, foto, narasi, dan materi</p>
                    </article>
                    
                    <article class="metric-card">
                        <div class="metric-card__body">
                            <dt><span class="metric-icon">📋</span> Status Konsultasi</dt>
                            <dd>
                                @foreach ($metrics['consultations_by_status'] as $status => $total)
                                    <span class="status-badge">{{ $consultationStatusLabels[$status] ?? str_replace('_', ' ', $status) }}: {{ $total }}</span>
                                @endforeach
                            </dd>
                        </div>
                        <p class="metric-card__hint">Gunakan untuk memantau antrian layanan</p>
                    </article>
                </div>
            </section>

            <section class="space-y-6">
                <div class="section-header">
                    <div class="section-icon">⏰</div>
                    <h2 class="section-title">Aktivitas Terbaru</h2>
                </div>
                <p class="section-subtitle">Konten dan konsultasi yang baru saja diperbarui</p>
                
                <div class="panel-grid">
                    <section class="panel">
                        <header class="panel__header">
                            <h3>
                                <div class="panel-icon">📚</div>
                                Konten Terbaru
                            </h3>
                        </header>
                        <div class="activity-list">
                            @forelse ($recentContents as $content)
                                <div class="activity-item">
                                    <div class="activity-title">{{ $content->title }}</div>
                                    <div class="activity-meta">
                                        <span class="type-badge">{{ $contentTypeLabels[$content->type] ?? ucfirst($content->type) }}</span>
                                        <span class="activity-time">🕒 {{ $content->updated_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    @if ($content->photo_url)
                                        <a href="{{ $content->photo_url }}" target="_blank" rel="noopener" class="preview-image">
                                            <img src="{{ $content->photo_url }}" alt="Pratinjau foto {{ $content->title }}" loading="lazy">
                                        </a>
                                    @elseif ($content->document_url)
                                        <a href="{{ $content->document_url }}" target="_blank" rel="noopener" class="download-link">
                                            📥 Unduh {{ strtoupper($content->document_extension ?? 'Berkas') }}
                                            @if ($content->document_size_bytes)
                                                @php
                                                    $recentDocBytes = $content->document_size_bytes;
                                                    $recentUnits = ['B', 'KB', 'MB', 'GB', 'TB'];
                                                    $recentSize = (float) $recentDocBytes;
                                                    $recentIndex = 0;
                                                    while ($recentSize >= 1024 && $recentIndex < count($recentUnits) - 1) {
                                                        $recentSize /= 1024;
                                                        $recentIndex++;
                                                    }
                                                    $recentPrecision = $recentIndex === 0 ? 0 : 1;
                                                    $recentFormatted = number_format($recentSize, $recentPrecision);
                                                    $recentFormatted = rtrim(rtrim($recentFormatted, '0'), '.');
                                                    $recentDocLabel = $recentFormatted . ' ' . $recentUnits[$recentIndex];
                                                @endphp
                                                <span>({{ $recentDocLabel }})</span>
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            @empty
                                <div class="empty-state">Belum ada konten</div>
                            @endforelse
                        </div>
                        <div class="panel__header">
                            <a href="{{ route('admin.contents.index') }}" class="accent-link">
                                Kelola Konten <span>→</span>
                            </a>
                        </div>
                    </section>
                    
                    <section class="panel">
                        <header class="panel__header">
                            <h3>
                                <div class="panel-icon">💬</div>
                                Konsultasi Terbaru
                            </h3>
                        </header>
                        <div class="activity-list">
                            @forelse ($recentConsultations as $consultation)
                                <div class="activity-item">
                                    <div class="activity-title">{{ $consultation->full_name }}</div>
                                    <div class="activity-meta">
                                        <span class="status-badge">{{ $consultationStatusLabels[$consultation->status] ?? str_replace('_', ' ', $consultation->status) }}</span>
                                        <span class="activity-time">🕒 {{ $consultation->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">Belum ada pengajuan</div>
                            @endforelse
                        </div>
                        <div class="panel__header">
                            <a href="{{ route('admin.consultations.index') }}" class="accent-link">
                                Kelola Konsultasi <span>→</span>
                            </a>
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>
@endsection