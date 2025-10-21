import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Layanan Konsultasi',
        href: '/konsultasi',
    },
];

type ConsultationRequestView = {
    id: number;
    uuid: string;
    full_name: string;
    phone: string;
    address_line: string | null;
    notes_from_public: string | null;
    status: string;
    status_label: string;
    submitted_at: string | null;
    source: string;
    whatsapp_url: string | null;
};

type ConsultationStats = {
    total: number;
    pending: number;
    today: number;
};

const followUpNotes = [
    {
        id: 1,
        title: 'Hubungi melalui WhatsApp',
        detail: 'Kirim pesan pengantar dan konfirmasi ketersediaan pengguna.',
    },
    {
        id: 2,
        title: 'Catat hasil konsultasi',
        detail: 'Masukkan ringkasan diskusi agar admin lain mengetahui progres.',
    },
    {
        id: 3,
        title: 'Perbarui status',
        detail: 'Ubah status ke selesai atau tindak lanjut agar antrian tetap rapih.',
    },
];

export default function ConsultationPage() {
    const { flash, requests = [], stats: incomingStats } = usePage<{
        flash?: { success?: string };
        requests?: ConsultationRequestView[];
        stats?: ConsultationStats;
    }>().props;

    const stats: ConsultationStats = incomingStats ?? { total: 0, pending: 0, today: 0 };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Layanan Konsultasi" />
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
                                Layanan Konsultasi
                            </Badge>
                            <CardTitle>Monitoring Pengajuan</CardTitle>
                            <CardDescription>
                                Lihat daftar permintaan terbaru yang harus ditindaklanjuti oleh tim admin.
                            </CardDescription>
                        </div>
                        <div className="grid gap-2 sm:grid-cols-3">
                            <div className="rounded-lg border border-border/50 bg-muted/40 px-3 py-2 text-xs">
                                <p className="font-semibold text-muted-foreground">Total Masuk</p>
                                <p className="mt-1 text-lg font-semibold text-foreground">{stats.total}</p>
                            </div>
                            <div className="rounded-lg border border-border/50 bg-muted/40 px-3 py-2 text-xs">
                                <p className="font-semibold text-muted-foreground">Menunggu Proses</p>
                                <p className="mt-1 text-lg font-semibold text-foreground">{stats.pending}</p>
                            </div>
                            <div className="rounded-lg border border-border/50 bg-muted/40 px-3 py-2 text-xs">
                                <p className="font-semibold text-muted-foreground">Masuk Hari Ini</p>
                                <p className="mt-1 text-lg font-semibold text-foreground">{stats.today}</p>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <div className="space-y-3 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            {requests.length === 0 ? (
                                <div className="rounded-lg border border-dashed border-border/60 p-6 text-center text-sm text-muted-foreground">
                                    Belum ada permintaan konsultasi terbaru.
                                </div>
                            ) : (
                                requests.map((request) => (
                                    <div key={request.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                        <div className="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                            <div>
                                                <p className="font-semibold text-foreground">{request.full_name}</p>
                                                <p className="text-xs text-muted-foreground">
                                                    Masuk {request.submitted_at ?? '-'}
                                                </p>
                                            </div>
                                            <Badge variant="secondary" className="w-fit">
                                                {request.status_label}
                                            </Badge>
                                        </div>
                                        <div className="mt-3 grid gap-3 text-xs sm:grid-cols-2">
                                            <div className="rounded-lg border border-border/50 bg-muted/40 px-3 py-2">
                                                <p className="font-semibold text-muted-foreground">WhatsApp</p>
                                                <p className="mt-0.5 truncate text-foreground">{request.phone}</p>
                                            </div>
                                            <div className="rounded-lg border border-border/50 bg-muted/40 px-3 py-2">
                                                <p className="font-semibold text-muted-foreground">Alamat</p>
                                                <p className="mt-0.5 text-foreground">
                                                    {request.address_line ?? 'Belum diisi'}
                                                </p>
                                            </div>
                                        </div>
                                        {request.notes_from_public && (
                                            <div className="mt-3 rounded-lg border border-border/50 bg-muted/30 px-3 py-2 text-xs text-muted-foreground">
                                                {request.notes_from_public}
                                            </div>
                                        )}
                                        <div className="mt-3 flex items-center justify-end gap-2">
                                            {request.whatsapp_url ? (
                                                <Button asChild size="sm">
                                                    <a
                                                        href={request.whatsapp_url}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                        className="px-3 py-2"
                                                    >
                                                        Hubungi via WhatsApp
                                                    </a>
                                                </Button>
                                            ) : (
                                                <Button size="sm" variant="outline" disabled>
                                                    Nomor tidak valid
                                                </Button>
                                            )}
                                        </div>
                                    </div>
                                ))
                            )}
                        </div>
                        <aside className="space-y-4 rounded-xl border border-border/60 bg-muted/30 p-4 text-sm text-muted-foreground">
                            <p className="font-semibold text-foreground">Catatan Alur</p>
                            <div className="space-y-3">
                                {followUpNotes.map((note) => (
                                    <div key={note.id} className="rounded-lg border border-border/50 p-3">
                                        <p className="font-medium text-foreground">{note.title}</p>
                                        <p className="mt-1 text-xs text-muted-foreground">{note.detail}</p>
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

