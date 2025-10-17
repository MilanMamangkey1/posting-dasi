import { useState } from 'react';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';

type VideoFormData = {
    title: string;
    duration: string;
    summary: string;
    mode: 'embed' | 'upload';
    video_url: string;
    video_file: File | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Video Edukasi',
        href: '/konten/video',
    },
];

type RecentVideo = {
    id: number;
    title: string;
    source: string;
    updated_at: string | null;
};

const textareaStyle =
    'border-input placeholder:text-muted-foreground focus-visible:ring-ring/50 focus-visible:border-ring focus-visible:ring-[3px] selection:bg-primary selection:text-primary-foreground w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition outline-none disabled:cursor-not-allowed disabled:opacity-50';

export default function VideoContentPage() {
    const [videoMode, setVideoMode] = useState<'embed' | 'upload'>('embed');
    const [fileInputKey, setFileInputKey] = useState(() => Date.now());
    const { flash, recentVideos = [] } = usePage<{
        flash?: { success?: string };
        recentVideos?: RecentVideo[];
    }>().props;

    const form = useForm<VideoFormData>({
        title: '',
        duration: '',
        summary: '',
        mode: 'embed',
        video_url: '',
        video_file: null,
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post('/konten/video', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                setVideoMode('embed');
                setFileInputKey(Date.now());
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Video Edukasi" />
            <div className="flex flex-1 flex-col gap-6 p-6">
                {flash?.success && (
                    <div className="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-300">
                        {flash.success}
                    </div>
                )}
                <Card>
                    <CardHeader className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <Badge variant="outline" className="mb-2 w-fit uppercase tracking-wide">
                                Video Edukasi
                            </Badge>
                            <CardTitle>Kelola Video</CardTitle>
                            <CardDescription>
                                Terima upload manual atau tempel link YouTube untuk menambah materi visual.
                            </CardDescription>
                        </div>
                        <Button variant="secondary">Lihat Arsip Video</Button>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <form
                            className="space-y-5 rounded-xl border border-border/60 bg-muted/30 p-4"
                            onSubmit={submit}
                            encType="multipart/form-data"
                        >
                            <div className="grid gap-4 md:grid-cols-2">
                                <div className="space-y-2">
                                    <label htmlFor="video-title" className="text-sm font-semibold text-foreground">
                                        Judul Video
                                    </label>
                                    <Input
                                        id="video-title"
                                        value={form.data.title}
                                        onChange={(event) => form.setData('title', event.target.value)}
                                        placeholder="Contoh: Tutorial simpul Windsor"
                                        required
                                    />
                                    <InputError message={form.errors.title} />
                                </div>
                                <div className="space-y-2">
                                    <label htmlFor="video-duration" className="text-sm font-semibold text-foreground">
                                        Durasi (menit)
                                    </label>
                                    <Input
                                        id="video-duration"
                                        type="number"
                                        min={1}
                                        max={180}
                                        value={form.data.duration}
                                        onChange={(event) => form.setData('duration', event.target.value)}
                                        placeholder="5"
                                    />
                                    <InputError message={form.errors.duration} />
                                </div>
                            </div>
                            <div className="space-y-2">
                                <span className="text-sm font-semibold text-foreground">Sumber Media</span>
                                <ToggleGroup
                                    type="single"
                                    variant="outline"
                                    value={videoMode}
                                    onValueChange={(value) => {
                                        if (value === 'embed' || value === 'upload') {
                                            setVideoMode(value);
                                            form.setData('mode', value);
                                            if (value === 'embed') {
                                                form.setData('video_file', null);
                                                setFileInputKey(Date.now());
                                            } else {
                                                form.setData('video_url', '');
                                            }
                                        }
                                    }}
                                    className="w-fit"
                                >
                                    <ToggleGroupItem value="embed">Embed YouTube</ToggleGroupItem>
                                    <ToggleGroupItem value="upload">Unggah Manual</ToggleGroupItem>
                                </ToggleGroup>
                                {videoMode === 'embed' ? (
                                    <>
                                        <Input
                                            type="url"
                                            placeholder="https://www.youtube.com/watch?v=..."
                                            aria-label="Link YouTube"
                                            value={form.data.video_url}
                                            onChange={(event) => form.setData('video_url', event.target.value)}
                                        />
                                        <InputError message={form.errors.video_url} />
                                    </>
                                ) : (
                                    <>
                                        <Input
                                            key={fileInputKey}
                                            type="file"
                                            accept="video/mp4,video/webm"
                                            aria-label="File video"
                                            onChange={(event) =>
                                                form.setData(
                                                    'video_file',
                                                    event.currentTarget.files?.[0] ?? null,
                                                )
                                            }
                                        />
                                        <InputError message={form.errors.video_file} />
                                    </>
                                )}
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="video-summary" className="text-sm font-semibold text-foreground">
                                    Ringkasan Video
                                </label>
                                <textarea
                                    id="video-summary"
                                    className={`${textareaStyle} min-h-[120px]`}
                                    placeholder="Tuliskan poin utama yang dibahas pada video..."
                                    value={form.data.summary}
                                    onChange={(event) => form.setData('summary', event.target.value)}
                                />
                                <InputError message={form.errors.summary} />
                            </div>
                            <div className="flex items-center justify-end gap-2">
                                <Button
                                    variant="ghost"
                                    type="button"
                                    onClick={() => {
                                        form.reset();
                                        setVideoMode('embed');
                                        setFileInputKey(Date.now());
                                    }}
                                >
                                    Reset
                                </Button>
                                <Button type="submit" disabled={form.processing}>
                                    {form.processing ? 'Menyimpan...' : 'Simpan Video'}
                                </Button>
                            </div>
                        </form>

                        <aside className="space-y-4 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            <p className="text-sm font-semibold text-foreground">Video Terbaru</p>
                            <div className="space-y-3">
                                {recentVideos.length === 0 && (
                                    <p className="rounded-lg border border-dashed border-border/60 p-3 text-xs text-muted-foreground">
                                        Belum ada video yang tersimpan. Tambahkan video pertama Anda.
                                    </p>
                                )}
                                {recentVideos.map((video) => (
                                    <div key={video.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                        <div className="flex items-center justify-between font-medium text-foreground">
                                            <span>{video.title}</span>
                                            <Badge variant="secondary">{video.source}</Badge>
                                        </div>
                                        <p className="mt-1 text-xs text-muted-foreground">
                                            Diperbarui {video.updated_at ?? '-'}
                                        </p>
                                    </div>
                                ))}
                            </div>
                        </aside>
                    </CardContent>
                    <CardFooter className="border-t border-border/60 py-4 text-xs text-muted-foreground">
                        Gunakan embed untuk hemat penyimpanan, atau unggah manual jika ingin menampilkan video privat.
                    </CardFooter>
                </Card>
            </div>
        </AppLayout>
    );
}
