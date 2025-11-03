@props([
    'size' => 'w-10 h-10',
    'secondarySize' => null,
    'gapClass' => 'gap-2',
    'secondaryPath' => 'logo/logo-secondary.png',
    'placeholder' => false,
    'primaryAlt' => 'Logo Posting Dasi',
    'secondaryAlt' => 'Logo Pendamping',
])

@php
    $secondarySize ??= $size;
    $primaryLogoUrl = asset('storage/logo/logotomohon.png');
    $storageDisk = \Illuminate\Support\Facades\Storage::disk('public');
    $secondaryLogoUrl = $storageDisk->exists($secondaryPath)
        ? asset('storage/' . ltrim($secondaryPath, '/'))
        : null;
@endphp

<div {{ $attributes->class(['flex items-center', $gapClass]) }}>
    <img
        src="{{ $primaryLogoUrl }}"
        alt="{{ $primaryAlt }}"
        class="{{ $size }} object-contain"
        loading="lazy"
    >

    @if ($secondaryLogoUrl)
        <img
            src="{{ $secondaryLogoUrl }}"
            alt="{{ $secondaryAlt }}"
            class="{{ $secondarySize }} object-contain"
            loading="lazy"
        >
    @elseif ($placeholder)
        <div class="{{ $secondarySize }} rounded-lg border border-dashed border-slate-300 flex items-center justify-center text-[10px] lg:text-xs font-medium uppercase tracking-wide text-slate-400">
            Logo
        </div>
    @endif
</div>
