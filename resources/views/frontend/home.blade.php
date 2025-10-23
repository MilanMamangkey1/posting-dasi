@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.public')

@section('title', 'Website Posting Dasi')

@section('body')
    <header class="border-b border-slate-200 bg-white/90">
        <div class="mx-auto flex max-w-5xl flex-col gap-3 px-6 py-8">
            <h1 class="text-3xl font-semibold text-slate-900">Website Posting Dasi</h1>
            <p class="text-base text-slate-600">
                Jelajahi konten edukasi dan ajukan konsultasi sesuai kebutuhan Anda. Tampilan ini masih sederhana dan akan terus dikembangkan.
            </p>
        </div>
    </header>

    <main class="mx-auto flex max-w-5xl flex-col gap-12 px-6 py-10">
        <section aria-labelledby="education-section">
            <h2 id="education-section" class="text-2xl font-semibold text-slate-900">Konten Edukasi</h2>
            <p class="mb-4 text-sm text-slate-600">
                Semua konten yang tersedia: video, foto, narasi, dan materi singkat.
            </p>

            @if ($videos->isEmpty() && $photos->isEmpty() && $narratives->isEmpty() && $materials->isEmpty())
                <p class="text-sm text-slate-500">Belum ada konten yang tersedia.</p>
            @else
                @if ($videos->isNotEmpty())
                    <div class="mb-8 space-y-4">
                        <h3 class="text-xl font-medium text-slate-800">Video</h3>
                        <div class="space-y-6">
                            @foreach ($videos as $video)
                                <article class="rounded-xl border border-slate-200 bg-white p-4">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $video->title }}</h4>
                                    @if ($video->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $video->summary }}</p>
                                    @endif
                                    @if ($video->embed_url)
                                        <div class="mt-4 aspect-video w-full overflow-hidden rounded-lg bg-slate-100">
                                            <iframe
                                                src="{{ $video->embed_url }}"
                                                title="YouTube video player"
                                                frameborder="0"
                                                allowfullscreen
                                                class="h-full w-full"
                                            ></iframe>
                                        </div>
                                    @elseif($video->source_url)
                                        <p class="mt-4 text-sm text-slate-600">
                                            Tonton di:
                                            <a href="{{ $video->source_url }}" class="text-slate-900 underline" target="_blank" rel="noopener">
                                                {{ $video->source_url }}
                                            </a>
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($photos->isNotEmpty())
                    <div class="mb-8 space-y-4">
                        <h3 class="text-xl font-medium text-slate-800">Foto</h3>
                        <div class="grid gap-6 sm:grid-cols-2">
                            @foreach ($photos as $photo)
                                <article class="rounded-xl border border-slate-200 bg-white p-4">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $photo->title }}</h4>
                                    @if ($photo->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $photo->summary }}</p>
                                    @endif
                                    @if ($photo->file_path)
                                        <img
                                            src="{{ Storage::url($photo->file_path) }}"
                                            alt="{{ $photo->title }}"
                                            class="mt-4 w-full rounded-lg object-cover"
                                        >
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($narratives->isNotEmpty())
                    <div class="mb-8 space-y-4">
                        <h3 class="text-xl font-medium text-slate-800">Narasi</h3>
                        <div class="space-y-6">
                            @foreach ($narratives as $narrative)
                                <article class="rounded-xl border border-slate-200 bg-white p-4">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $narrative->title }}</h4>
                                    @if ($narrative->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $narrative->summary }}</p>
                                    @endif
                                    @if ($narrative->body)
                                        <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">
                                            {{ $narrative->body }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($materials->isNotEmpty())
                    <div class="space-y-4">
                        <h3 class="text-xl font-medium text-slate-800">Materi Edukasi</h3>
                        <div class="space-y-6">
                            @foreach ($materials as $material)
                                <article class="rounded-xl border border-slate-200 bg-white p-4">
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $material->title }}</h4>
                                    @if ($material->summary)
                                        <p class="mt-2 text-sm text-slate-600">{{ $material->summary }}</p>
                                    @endif
                                    @if ($material->body)
                                        <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">
                                            {{ $material->body }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </section>

        <section aria-labelledby="consultation-section" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 id="consultation-section" class="text-2xl font-semibold text-slate-900">Ajukan Konsultasi</h2>
            <p class="mt-2 text-sm text-slate-600">
                Isi formulir di bawah ini untuk mengajukan konsultasi. Tim kami akan menghubungi Anda melalui WhatsApp.
            </p>

            @if ($submissionStatus)
                <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ $submissionStatus }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    Silakan periksa kembali formulir Anda.
                </div>
            @endif

            <form method="POST" action="{{ route('public.consultations.store') }}" class="mt-6 space-y-4">
                @csrf
                <div class="flex flex-col gap-2">
                    <label for="full_name" class="text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        value="{{ old('full_name') }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
                    >
                </div>
                <div class="flex flex-col gap-2">
                    <label for="address" class="text-sm font-medium text-slate-700">Alamat</label>
                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
                    >{{ old('address') }}</textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="issue_description" class="text-sm font-medium text-slate-700">Deskripsi Permasalahan</label>
                    <textarea
                        id="issue_description"
                        name="issue_description"
                        rows="4"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
                    >{{ old('issue_description') }}</textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="whatsapp_number" class="text-sm font-medium text-slate-700">Nomor WhatsApp</label>
                    <input
                        id="whatsapp_number"
                        name="whatsapp_number"
                        type="tel"
                        value="{{ old('whatsapp_number') }}"
                        placeholder="+628xxxxxxxxxx"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
                    >
                    <p class="text-xs text-slate-500">Gunakan format internasional (contoh: +6281234567890).</p>
                </div>
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900"
                >
                    Kirim Pengajuan
                </button>
            </form>
        </section>
    </main>
@endsection
