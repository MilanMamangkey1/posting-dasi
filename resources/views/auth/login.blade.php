<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Masuk - Website Posting Dasi</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --primary-red: #c53030; /* Warna merah tidak terlalu terang */
                --primary-red-light: #fed7d7;
                --primary-red-dark: #9b2c2c;
                --primary-red-hover: #b91c1c;
                --text-dark: #2d3748;
                --text-light: #718096;
                --bg-light: #f7fafc;
                --border-light: #e2e8f0;
            }
            
            body {
                background: linear-gradient(135deg, #fef2f2 0%, #fed7d7 50%, #feb2b2 100%);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            .login-container {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.8);
            }
            
            .logo-container {
                display: flex;
                justify-content: center;
                margin-bottom: 1.5rem;
            }
            
            .logo-placeholder {
                width: 80px;
                height: 80px;
                background-color: var(--primary-red);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
                font-size: 1.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            .title {
                color: var(--primary-red);
                font-weight: 700;
                margin-bottom: 0.5rem;
            }
            
            .subtitle {
                color: var(--text-light);
                font-size: 0.9rem;
            }
            
            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid var(--border-light);
                border-radius: 8px;
                transition: all 0.3s ease;
                background-color: white;
            }
            
            .form-input:focus {
                outline: none;
                border-color: var(--primary-red);
                box-shadow: 0 0 0 3px rgba(197, 48, 48, 0.1);
            }
            
            .primary-button {
                background-color: var(--primary-red);
                color: white;
                border: none;
                border-radius: 8px;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .primary-button:hover {
                background-color: var(--primary-red-hover);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(197, 48, 48, 0.3);
            }
            
            .checkbox-container {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--text-light);
            }
            
            .checkbox-container input[type="checkbox"] {
                accent-color: var(--primary-red);
            }
            
            .error-message {
                background-color: var(--primary-red-light);
                border: 1px solid var(--primary-red);
                color: var(--primary-red-dark);
                border-radius: 8px;
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
            
            .footer-text {
                text-align: center;
                margin-top: 1.5rem;
                color: var(--text-light);
                font-size: 0.8rem;
            }
        </style>
    </head>
    <body class="min-h-screen font-sans antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-12">
            <div class="login-container w-full max-w-md space-y-8 p-8">
                <div class="logo-container">
                    <div class="logo-placeholder">
                        PD
                    </div>
                </div>
                
                <div class="space-y-2 text-center">
                    <h1 class="title text-2xl">Login Admin Posting Dasi</h1>
                    <p class="subtitle">
                        Masuk untuk mengelola konten edukasi dan pengajuan konsultasi.
                    </p>
                </div>
                
                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-slate-700">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="form-input"
                          
                        >
                    </div>
                    
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-slate-700">
                            Password
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="form-input"
                        >
                    </div>
                    
    
                    
                    <button type="submit" class="primary-button w-full">
                        Masuk
                    </button>
                </form>
                
                <div class="footer-text">
                    &copy; 2025 Posting Dasi. Hak Cipta Dilindungi.
                </div>
            </div>
        </main>
    </body>
</html>