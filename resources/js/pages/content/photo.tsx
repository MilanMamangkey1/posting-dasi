import { useMemo, useState } from 'react';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
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

type RecentPhoto = {
    id: number;
    title: string;
    photo_count: number;
    updated_at: string | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Galeri Foto',
        href: '/konten/foto',
    },
];

const textareaStyle =
    'border-input placeholder:text-muted-foreground focus-visible:ring-ring/50 focus-visible:border-ring focus-visible:ring-[3px] selection:bg-primary selection:text-primary-foreground w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition outline-none disabled:cursor-not-allowed disabled:opacity-50';

export default function PhotoContentPage() {
    const [fileInputKey, setFileInputKey] = useState(() => Date.now());
    const { flash, recentPhotos = [] } = usePage<{
        flash?: { success?: string };
        recentPhotos?: RecentPhoto[];
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
            <Head title="Galeri Foto" />
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
                                Galeri Foto
                            </Badge>
                            <CardTitle>Kelola Album</CardTitle>
                            <CardDescription>
                                Unggah foto pendukung langkah atau dokumentasi untuk memperjelas materi.
                            </CardDescription>
                        </div>
                        <Button variant="secondary">Lihat Semua Album</Button>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <form
                            className="space-y-5 rounded-xl border border-border/60 bg-muted/30 p-4"
                            onSubmit={submit}
                            encType="multipart/form-data"
                        >
                            <div className="space-y-2">
                                <label htmlFor="photo-title" className="text-sm font-semibold text-foreground">
                                    Judul Album
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
                                    {form.processing ? 'Menyimpan...' : 'Simpan Album'}
                                </Button>
                            </div>
                        </form>
                        <aside className="space-y-4 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            <p className="text-sm font-semibold text-foreground">Album Terbaru</p>
                            <div className="space-y-3">
                                {recentPhotos.length === 0 && (
                                    <p className="rounded-lg border border-dashed border-border/60 p-3 text-xs text-muted-foreground">
                                        Belum ada album foto yang tersimpan.
                                    </p>
                                )}
                                {recentPhotos.map((photo) => (
                                    <div key={photo.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                        <div className="flex items-center justify-between font-medium text-foreground">
                                            <span>{photo.title}</span>
                                            <Badge variant="secondary">{photo.photo_count} foto</Badge>
                                        </div>
                                        <p className="mt-1 text-xs text-muted-foreground">
                                            Diperbarui {photo.updated_at ?? '-'}
                                        </p>
                                    </div>
                                ))}
                            </div>
                        </aside>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}