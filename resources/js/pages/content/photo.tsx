import { useMemo, useState } from 'react';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';

type PhotoFormData = {
    title: string;
    description: string;
    tags: string;
    photos: File[];
};

type PhotoPreview = {
    id: number;
    url: string;
    caption: string | null;
};

type RecentPhoto = {
    id: number;
    title: string;
    photo_count: number;
    updated_at: string | null;
    preview_photos: PhotoPreview[];
};

type FotoEntry = {
    id: number;
    title: string;
    photo_count: number;
    updated_at: string | null;
    photos: PhotoPreview[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Foto',
        href: '/konten/foto',
    },
];

const textareaStyle =
    'border-input placeholder:text-muted-foreground focus-visible:ring-ring/50 focus-visible:border-ring focus-visible:ring-[3px] selection:bg-primary selection:text-primary-foreground w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition outline-none disabled:cursor-not-allowed disabled:opacity-50';

export default function PhotoContentPage() {
    const [fileInputKey, setFileInputKey] = useState(() => Date.now());
    const { flash, recentPhotos = [], fotoEntries = [] } = usePage<{
        flash?: { success?: string };
        recentPhotos?: RecentPhoto[];
        fotoEntries?: FotoEntry[];
    }>().props;

    const form = useForm<PhotoFormData>({
        title: '',
        description: '',
        tags: '',
        photos: [],
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post('/konten/foto', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                setFileInputKey(Date.now());
            },
        });
    };

    const photoFieldError = useMemo(() => {
        if (form.errors.photos) {
            return form.errors.photos;
        }

        const genericErrors = form.errors as Record<string, string>;
        return (
            Object.entries(genericErrors).find(([key]) => key.startsWith('photos.'))?.[1] ?? undefined
        );
    }, [form.errors]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Foto" />
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
                                Foto
                            </Badge>
                            <CardTitle>Kelola Foto</CardTitle>
                            <CardDescription>
                                Unggah foto pendukung langkah atau dokumentasi untuk memperjelas materi.
                            </CardDescription>
                        </div>
                        <Dialog>
                            <DialogTrigger asChild>
                                <Button variant="secondary">Lihat Semua Foto</Button>
                            </DialogTrigger>
                            <DialogContent className="max-h-[90vh] w-full max-w-5xl overflow-hidden sm:max-w-5xl">
                                <DialogHeader className="text-left">
                                    <DialogTitle>Semua Foto</DialogTitle>
                                    <DialogDescription>
                                        Telusuri seluruh foto yang sudah tersimpan.
                                    </DialogDescription>
                                </DialogHeader>
                                <div className="max-h-[65vh] overflow-y-auto pr-1">
                                    {fotoEntries.length === 0 ? (
                                        <p className="rounded-lg border border-dashed border-border/60 p-4 text-sm text-muted-foreground">
                                            Belum ada foto yang diunggah.
                                        </p>
                                    ) : (
                                        <div className="space-y-4 pr-1">
                                            {fotoEntries.map((entry) => (
                                                <div
                                                    key={entry.id}
                                                    className="rounded-lg border border-border/60 bg-background p-4 shadow-sm"
                                                >
                                                    <div className="flex flex-wrap items-center justify-between gap-2">
                                                        <div>
                                                            <p className="text-sm font-semibold text-foreground">
                                                                {entry.title}
                                                            </p>
                                                            <p className="text-xs text-muted-foreground">
                                                                Diperbarui {entry.updated_at ?? '-'}
                                                            </p>
                                                        </div>
                                                        <Badge variant="secondary">{entry.photo_count} foto</Badge>
                                                    </div>
                                                    {entry.photos.length > 0 ? (
                                                        <div className="mt-3 grid gap-2 sm:grid-cols-2 md:grid-cols-3">
                                                            {entry.photos.map((photo) => (
                                                                <div
                                                                    key={photo.id}
                                                                    className="relative aspect-[4/3] overflow-hidden rounded-md border border-border/60 bg-muted"
                                                                >
                                                                    <img
                                                                        src={photo.url}
                                                                        alt={
                                                                            photo.caption ??
                                                                            `Foto ${entry.title}`
                                                                        }
                                                                        className="h-full w-full object-cover"
                                                                        loading="lazy"
                                                                    />
                                                                </div>
                                                            ))}
                                                        </div>
                                                    ) : (
                                                        <p className="mt-3 rounded-lg border border-dashed border-border/60 p-3 text-xs text-muted-foreground">
                                                            Belum ada foto tersimpan.
                                                        </p>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    )}
                                </div>
                            </DialogContent>
                        </Dialog>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <form
                            className="space-y-5 rounded-xl border border-border/60 bg-muted/30 p-4"
                            onSubmit={submit}
                            encType="multipart/form-data"
                        >
                            <div className="space-y-2">
                                <label htmlFor="photo-title" className="text-sm font-semibold text-foreground">
                                    Judul Foto
                                </label>
                                <Input
                                    id="photo-title"
                                    value={form.data.title}
                                    onChange={(event) => form.setData('title', event.target.value)}
                                    placeholder="Contoh: Detail langkah simpul Pratt"
                                    required
                                />
                                <InputError message={form.errors.title} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="photo-description" className="text-sm font-semibold text-foreground">
                                    Deskripsi Singkat
                                </label>
                                <textarea
                                    id="photo-description"
                                    className={`${textareaStyle} min-h-[100px]`}
                                    placeholder="Berikan konteks kapan foto ini digunakan..."
                                    value={form.data.description}
                                    onChange={(event) => form.setData('description', event.target.value)}
                                />
                                <InputError message={form.errors.description} />
                            </div>
                            <div className="space-y-2">
                                <span className="text-sm font-semibold text-foreground">Unggah Foto</span>
                                <Input
                                    key={fileInputKey}
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    aria-label="File foto"
                                    onChange={(event) =>
                                        form.setData(
                                            'photos',
                                            event.currentTarget.files
                                                ? Array.from(event.currentTarget.files)
                                                : [],
                                        )
                                    }
                                />
                                <p className="text-xs text-muted-foreground">
                                    Format disarankan: JPG/PNG, ukuran maksimal 2MB per file.
                                </p>
                                <InputError message={photoFieldError} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="photo-tags" className="text-sm font-semibold text-foreground">
                                    Tag (opsional)
                                </label>
                                <Input
                                    id="photo-tags"
                                    value={form.data.tags}
                                    onChange={(event) => form.setData('tags', event.target.value)}
                                    placeholder="tutorial, visual, dasi"
                                />
                                <InputError message={form.errors.tags} />
                            </div>
                            <div className="flex items-center justify-end gap-2">
                                <Button
                                    variant="ghost"
                                    type="button"
                                    onClick={() => {
                                        form.reset();
                                        setFileInputKey(Date.now());
                                    }}
                                >
                                    Reset
                                </Button>
                                <Button type="submit" disabled={form.processing}>
                                    {form.processing ? 'Menyimpan...' : 'Simpan Foto'}
                                </Button>
                            </div>
                        </form>
                        <aside className="space-y-4 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            <p className="text-sm font-semibold text-foreground">Foto Terbaru</p>
                            <div className="space-y-3">
                                {recentPhotos.length === 0 && (
                                    <p className="rounded-lg border border-dashed border-border/60 p-3 text-xs text-muted-foreground">
                                        Belum ada foto yang tersimpan.
                                    </p>
                                )}
                                {recentPhotos.map((photo) => {
                                    const previewCount = photo.preview_photos.length;
                                    const remainingCount = Math.max(photo.photo_count - previewCount, 0);

                                    return (
                                        <div key={photo.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                            <div className="flex items-center justify-between gap-2 font-medium text-foreground">
                                                <span className="truncate">{photo.title}</span>
                                                <Badge variant="secondary">{photo.photo_count} foto</Badge>
                                            </div>
                                            <p className="mt-1 text-xs text-muted-foreground">
                                                Diperbarui {photo.updated_at ?? '-'}
                                            </p>
                                            {previewCount > 0 ? (
                                                <div className="mt-3 flex gap-2">
                                                    {photo.preview_photos.map((preview) => (
                                                        <div
                                                            key={preview.id}
                                                            className="relative h-12 w-12 overflow-hidden rounded-md border border-border/60 bg-muted"
                                                        >
                                                            <img
                                                                src={preview.url}
                                                                alt={preview.caption ?? `Foto ${photo.title}`}
                                                                className="h-full w-full object-cover"
                                                                loading="lazy"
                                                            />
                                                        </div>
                                                    ))}
                                                    {remainingCount > 0 && (
                                                        <div className="flex h-12 w-12 items-center justify-center rounded-md border border-dashed border-border/60 text-[11px] font-medium text-muted-foreground">
                                                            +{remainingCount}
                                                        </div>
                                                    )}
                                                </div>
                                            ) : (
                                                <p className="mt-3 text-xs italic text-muted-foreground">
                                                    Belum ada foto tersimpan.
                                                </p>
                                            )}
                                        </div>
                                    );
                                })}
                            </div>
                        </aside>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
