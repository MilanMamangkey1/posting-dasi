import { PublicConsultationForm } from '@/components/public-consultation-form';
import { Head, usePage } from '@inertiajs/react';

type VideoItem = {
    id: number;
    title: string;
    summary: string | null;
    video_url: string | null;
    media_url: string | null;
    updated_at: string | null;
};

type PhotoItem = {
    id: number;
    title: string;
    photos: { id: number; url: string | null; caption: string | null }[];
    updated_at: string | null;
};

type NarrativeItem = {
    id: number;
    title: string;
    summary: string | null;
    body: string | null;
    updated_at: string | null;
};

type MaterialItem = {
    id: number;
    title: string;
    summary: string | null;
    format: string | null;
    external_link: string | null;
    download_url: string | null;
    updated_at: string | null;
};

type PageProps = {
    videos: VideoItem[];
    photos: PhotoItem[];
    narratives: NarrativeItem[];
    materials: MaterialItem[];
    consultation: { source: string; redirect_url: string };
    flash?: { success?: string };
};

export default function PublicHomePage() {
    const { videos = [], photos = [], narratives = [], materials = [], consultation, flash } =
        usePage<PageProps>().props;

    return (
        <div className="min-h-screen bg-white text-black">
            <Head title="Portal Edukasi Dasi" />
            <header className="mx-auto w-full max-w-5xl px-4 py-8">
                <h1 className="text-2xl font-semibold">Posting Dasi</h1>
                <p className="mt-2 text-sm text-neutral-600">
                    Jelajahi materi edukasi mengenai Stunting.
                </p>
            </header>
            <main className="mx-auto flex w-full max-w-5xl flex-col gap-8 px-4 pb-16">
                <section className="space-y-3">
                    <h2 className="text-xl font-semibold">Video Edukasi</h2>
                    <ul className="space-y-3 text-sm">
                        {videos.length === 0 && <li>Tidak ada video untuk ditampilkan.</li>}
                        {videos.map((video) => (
                            <li key={video.id} className="space-y-1">
                                <p className="font-medium">{video.title}</p>
                                {video.summary && <p className="text-neutral-600">{video.summary}</p>}
                                <div className="flex gap-3 text-xs text-blue-600">
                                    {video.video_url && (
                                        <a href={video.video_url} target="_blank" rel="noreferrer">
                                            Tonton via Link
                                        </a>
                                    )}
                                    {video.media_url && (
                                        <a href={video.media_url} target="_blank" rel="noreferrer">
                                            Unduh Video
                                        </a>
                                    )}
                                </div>
                            </li>
                        ))}
                    </ul>
                </section>

                <section className="space-y-3">
                    <h2 className="text-xl font-semibold">Galeri Foto</h2>
                    <ul className="space-y-4 text-sm">
                        {photos.length === 0 && <li>Tidak ada foto untuk ditampilkan.</li>}
                        {photos.map((collection) => (
                            <li key={collection.id} className="space-y-2">
                                <p className="font-medium">{collection.title}</p>
                                <div className="flex flex-wrap gap-2">
                                    {collection.photos.length === 0 && (
                                        <span className="text-neutral-600">Belum ada foto terlampir.</span>
                                    )}
                                    {collection.photos.map((photo) => (
                                        <img
                                            key={photo.id}
                                            src={photo.url ?? ''}
                                            alt={photo.caption ?? collection.title}
                                            className="h-32 w-32 rounded object-cover"
                                        />
                                    ))}
                                </div>
                            </li>
                        ))}
                    </ul>
                </section>

                <section className="space-y-3">
                    <h2 className="text-xl font-semibold">Narasi Edukasi</h2>
                    <ul className="space-y-3 text-sm">
                        {narratives.length === 0 && <li>Tidak ada narasi untuk ditampilkan.</li>}
                        {narratives.map((narrative) => (
                            <li key={narrative.id} className="space-y-1">
                                <p className="font-medium">{narrative.title}</p>
                                {narrative.summary && <p className="text-neutral-600">{narrative.summary}</p>}
                            </li>
                        ))}
                    </ul>
                </section>

                <section className="space-y-3">
                    <h2 className="text-xl font-semibold">Materi Pendukung</h2>
                    <ul className="space-y-3 text-sm">
                        {materials.length === 0 && <li>Tidak ada materi untuk ditampilkan.</li>}
                        {materials.map((material) => (
                            <li key={material.id} className="space-y-1">
                                <p className="font-medium">{material.title}</p>
                                {material.summary && <p className="text-neutral-600">{material.summary}</p>}
                                <div className="flex gap-3 text-xs text-blue-600">
                                    {material.external_link && (
                                        <a href={material.external_link} target="_blank" rel="noreferrer">
                                            Buka Link
                                        </a>
                                    )}
                                    {material.download_url && (
                                        <a href={material.download_url} target="_blank" rel="noreferrer">
                                            Unduh Materi
                                        </a>
                                    )}
                                </div>
                            </li>
                        ))}
                    </ul>
                </section>

                <section className="space-y-3">
                    <h2 className="text-xl font-semibold">Konsultasi WhatsApp</h2>
                    <PublicConsultationForm
                        source={consultation.source}
                        redirectUrl={consultation.redirect_url}
                        successMessage={flash?.success}
                    />
                </section>
            </main>
        </div>
    );
}

