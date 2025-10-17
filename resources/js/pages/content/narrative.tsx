import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';

interface NarrativeFormData {
    title: string;
    body: string;
    tags: string;
    reference: string;
}

interface RecentNarrative {
    id: number;
    title: string;
    summary: string | null;
    updated_at: string | null;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Narasi',
        href: '/konten/narasi',
    },
];

const textareaStyle =
    'border-input placeholder:text-muted-foreground focus-visible:ring-ring/50 focus-visible:border-ring focus-visible:ring-[3px] selection:bg-primary selection:text-primary-foreground w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition outline-none disabled:cursor-not-allowed disabled:opacity-50';

export default function NarrativeContentPage() {
    const { flash, recentNarratives = [] } = usePage<{
        flash?: { success?: string };
        recentNarratives?: RecentNarrative[];
    }>().props;

    const form = useForm<NarrativeFormData>({
        title: '',
        body: '',
        tags: '',
        reference: '',
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post('/konten/narasi', {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Narasi" />
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
                                Narasi
                            </Badge>
                            <CardTitle>Tulis Narasi Edukasi</CardTitle>
                            <CardDescription>
                                Narasi dapat berdiri sendiri atau mendampingi video dan foto di halaman publik.
                            </CardDescription>
                        </div>
                        <Button variant="secondary">Lihat Semua Narasi</Button>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <form
                            className="space-y-5 rounded-xl border border-border/60 bg-muted/30 p-4"
                            onSubmit={submit}
                        >
                            <div className="space-y-2">
                                <label htmlFor="narrative-title" className="text-sm font-semibold text-foreground">
                                    Judul Narasi
                                </label>
                                <Input
                                    id="narrative-title"
                                    value={form.data.title}
                                    onChange={(event) => form.setData('title', event.target.value)}
                                    placeholder="Contoh: Kenapa simpul half Windsor populer?"
                                    required
                                />
                                <InputError message={form.errors.title} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="narrative-content" className="text-sm font-semibold text-foreground">
                                    Isi Narasi
                                </label>
                                <textarea
                                    id="narrative-content"
                                    className={`${textareaStyle} min-h-[200px]`}
                                    placeholder="Tulis narasi edukasi secara runut..."
                                    value={form.data.body}
                                    onChange={(event) => form.setData('body', event.target.value)}
                                    required
                                />
                                <InputError message={form.errors.body} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="narrative-tags" className="text-sm font-semibold text-foreground">
                                    Tag (opsional)
                                </label>
                                <Input
                                    id="narrative-tags"
                                    value={form.data.tags}
                                    onChange={(event) => form.setData('tags', event.target.value)}
                                    placeholder="etiket, dasi, tutorial"
                                />
                                <InputError message={form.errors.tags} />
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="narrative-source" className="text-sm font-semibold text-foreground">
                                    Referensi (opsional)
                                </label>
                                <Input
                                    id="narrative-source"
                                    type="url"
                                    value={form.data.reference}
                                    onChange={(event) => form.setData('reference', event.target.value)}
                                    placeholder="https://..."
                                />
                                <InputError message={form.errors.reference} />
                            </div>
                            <div className="flex items-center justify-end gap-2">
                                <Button variant="ghost" type="button" onClick={() => form.reset()}>
                                    Reset
                                </Button>
                                <Button type="submit" disabled={form.processing}>
                                    {form.processing ? 'Menyimpan...' : 'Simpan Narasi'}
                                </Button>
                            </div>
                        </form>
                        <aside className="space-y-4 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            <p className="text-sm font-semibold text-foreground">Narasi Terbaru</p>
                            <div className="space-y-3">
                                {recentNarratives.length === 0 && (
                                    <p className="rounded-lg border border-dashed border-border/60 p-3 text-xs text-muted-foreground">
                                        Belum ada narasi yang tersimpan.
                                    </p>
                                )}
                                {recentNarratives.map((item) => (
                                    <div key={item.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                        <p className="font-medium text-foreground">{item.title}</p>
                                        {item.summary && (
                                            <p className="mt-1 text-xs text-muted-foreground">
                                                {item.summary}
                                            </p>
                                        )}
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