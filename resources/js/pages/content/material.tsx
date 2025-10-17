import { useState } from 'react';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';

interface MaterialFormData {
    title: string;
    format: string;
    file: File | null;
    link: string;
    notes: string;
}

interface RecentMaterial {
    id: number;
    title: string;
    format: string;
    updated_at: string | null;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Materi Pendukung',
        href: '/konten/materi',
    },
];

const textareaStyle =
    'border-input placeholder:text-muted-foreground focus-visible:ring-ring/50 focus-visible:border-ring focus-visible:ring-[3px] selection:bg-primary selection:text-primary-foreground w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition outline-none disabled:cursor-not-allowed disabled:opacity-50';

export default function MaterialContentPage() {
    const [fileInputKey, setFileInputKey] = useState(() => Date.now());
    const { flash, recentMaterials = [] } = usePage<{
        flash?: { success?: string };
        recentMaterials?: RecentMaterial[];
    }>().props;

    const form = useForm<MaterialFormData>({
        title: '',
        format: '',
        file: null,
        link: '',
        notes: '',
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post('/konten/materi', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                setFileInputKey(Date.now());
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Materi Pendukung" />
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
                                Materi Pendukung
                            </Badge>
                            <CardTitle>Upload Materi</CardTitle>
                            <CardDescription>
                                Unggah modul, slide, atau panduan tambahan guna melengkapi pembelajaran.
                            </CardDescription>
                        </div>
                        <Button variant="secondary">Buka Koleksi Materi</Button>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <form
                            className="space-y-5 rounded-xl border border-border/60 bg-muted/30 p-4"
                            onSubmit={submit}
                            encType="multipart/form-data"
                        >
                            <div className="grid gap-4 md:grid-cols-2">
                                <div className="space-y-2">
                                    <label htmlFor="material-title" className="text-sm font-semibold text-foreground">
                                        Judul Materi
                                    </label>
                                    <Input
                                        id="material-title"
                                        value={form.data.title}
                                        onChange={(event) => form.setData('title', event.target.value)}
                                        placeholder="Contoh: Modul latihan simpul lengkap"
                                        required
                                    />
                                    <InputError message={form.errors.title} />
                                </div>
                                <div className="space-y-2">
                                    <label htmlFor="material-format" className="text-sm font-semibold text-foreground">
                                        Format File
                                    </label>
                                    <Input
                                        id="material-format"
                                        value={form.data.format}
                                        onChange={(event) => form.setData('format', event.target.value)}
                                        placeholder="PDF / PPT / DOC"
                                    />
                                    <InputError message={form.errors.format} />
                                </div>
                            </div>
                            <div className="space-y-2">
                                <span className="text-sm font-semibold text-foreground">Lampiran Materi</span>
                                <Input
                                    key={fileInputKey}
                                    type="file"
                                    accept=".pdf,.ppt,.pptx,.doc,.docx"
                                    aria-label="File materi"
                                    onChange={(event) =>
                                        form.setData('file', event.currentTarget.files?.[0] ?? null)
                                    }
                                />
                                <InputError message={form.errors.file} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="material-link" className="text-sm font-semibold text-foreground">
                                    Tautan Eksternal (opsional)
                                </label>
                                <Input
                                    id="material-link"
                                    type="url"
                                    value={form.data.link}
                                    onChange={(event) => form.setData('link', event.target.value)}
                                    placeholder="https://drive.google.com/..."
                                />
                                <InputError message={form.errors.link} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="material-notes" className="text-sm font-semibold text-foreground">
                                    Catatan untuk Admin Lain
                                </label>
                                <textarea
                                    id="material-notes"
                                    className={`${textareaStyle} min-h-[120px]`}
                                    placeholder="Informasi tambahan mengenai pemakaian materi..."
                                    value={form.data.notes}
                                    onChange={(event) => form.setData('notes', event.target.value)}
                                />
                                <InputError message={form.errors.notes} />
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
                                    {form.processing ? 'Menyimpan...' : 'Simpan Materi'}
                                </Button>
                            </div>
                        </form>
                        <aside className="space-y-4 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            <p className="text-sm font-semibold text-foreground">Materi Terbaru</p>
                            <div className="space-y-3">
                                {recentMaterials.length === 0 && (
                                    <p className="rounded-lg border border-dashed border-border/60 p-3 text-xs text-muted-foreground">
                                        Belum ada materi pendukung yang tersimpan.
                                    </p>
                                )}
                                {recentMaterials.map((item) => (
                                    <div key={item.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                        <div className="flex items-center justify-between font-medium text-foreground">
                                            <span>{item.title}</span>
                                            <Badge variant="secondary">{item.format}</Badge>
                                        </div>
                                        <p className="mt-1 text-xs text-muted-foreground">
                                            Diperbarui {item.updated_at ?? '-'}
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