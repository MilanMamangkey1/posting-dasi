<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Masuk - Website Posting Dasi</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-200 to-slate-100 font-sans text-slate-900 antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-12">
            <div class="w-full max-w-md space-y-8 rounded-3xl border border-slate-200 bg-white/90 p-8 shadow-xl backdrop-blur">
                <div class="space-y-2 text-center">
                    <h1 class="text-2xl font-semibold text-slate-900">Login Admin Backend</h1>
                    <p class="text-sm text-slate-500">
                        Masuk untuk mengelola konten edukasi dan pengajuan konsultasi.
                    </p>
                </div>
                @if ($errors->any())
                    <div class="rounded-lg border border-red-600 bg-white px-4 py-3 text-sm text-red-600">
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
                            placeholder="admin@example.com"
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
                            placeholder="••••••••"
                        >
                    </div>
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                        <span>Ingat saya</span>
                    </label>
                    <button type="submit" class="primary-button w-full justify-center">
                        Masuk
                    </button>
                </form>
            </div>
        </main>
    </body>
</html>
