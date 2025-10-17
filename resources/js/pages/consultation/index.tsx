import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

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

const consultationQueue = [
    { id: 1, name: 'Siti Rahma', status: 'Menunggu respon', submittedAt: '17 Okt 2025' },
    { id: 2, name: 'Andi Pratama', status: 'Dijadwalkan', submittedAt: '16 Okt 2025' },
    { id: 3, name: 'Lestari Putri', status: 'Dalam review', submittedAt: '14 Okt 2025' },
];

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
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Layanan Konsultasi" />
            <div className="flex flex-1 flex-col gap-6 p-6">
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
                        <Button variant="secondary">Kelola Jadwal</Button>
                    </CardHeader>
                    <CardContent className="grid gap-6 lg:grid-cols-[2fr,1fr]">
                        <div className="space-y-3 rounded-xl border border-border/60 bg-background p-4 shadow-sm">
                            {consultationQueue.map((request) => (
                                <div key={request.id} className="rounded-lg border border-border/50 p-3 text-sm">
                                    <div className="flex items-center justify-between font-medium text-foreground">
                                        <span>{request.name}</span>
                                        <Badge variant="secondary">{request.status}</Badge>
                                    </div>
                                    <p className="mt-1 text-xs text-muted-foreground">
                                        Masuk {request.submittedAt}
                                    </p>
                                </div>
                            ))}
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
