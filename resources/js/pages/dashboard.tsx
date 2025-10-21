import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import {
    PlayCircle,
    Image as ImageIcon,
    FileText,
    Layers,
    MessageSquare,
} from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const resourceCards = [
    {
        title: 'Video Edukasi',
        description: 'Kelola unggahan atau link YouTube untuk materi visual.',
        href: '/konten/video',
        icon: PlayCircle,
        accent: 'bg-sky-500/10 text-sky-700 border-sky-500/30 dark:text-sky-200',
    },
    {
        title: 'Foto',
        description: 'Simpan foto langkah dan dokumentasi pendukung.',
        href: '/konten/foto',
        icon: ImageIcon,
        accent: 'bg-amber-500/10 text-amber-700 border-amber-500/30 dark:text-amber-200',
    },
    {
        title: 'Narasi',
        description: 'Tulis artikel atau naskah edukasi yang rapi.',
        href: '/konten/narasi',
        icon: FileText,
        accent: 'bg-emerald-500/10 text-emerald-700 border-emerald-500/30 dark:text-emerald-200',
    },
    {
        title: 'Materi Pendukung',
        description: 'Unggah modul, slide, atau file tambahan lainnya.',
        href: '/konten/materi',
        icon: Layers,
        accent: 'bg-violet-500/10 text-violet-700 border-violet-500/30 dark:text-violet-200',
    },
    {
        title: 'Layanan Konsultasi',
        description: 'Pantau dan respon permintaan konsultasi dari publik.',
        href: '/konsultasi',
        icon: MessageSquare,
        accent: 'bg-indigo-500/10 text-indigo-700 border-indigo-500/30 dark:text-indigo-200',
    },
];

const activityTimeline = [
    {
        title: 'Video "Simpul Windsor" diperbarui',
        time: '16 Okt 2025',
    },
    {
        title: '3 permintaan konsultasi masuk via dashboard publik',
        time: '15 Okt 2025',
    },
    {
        title: 'Foto "Langkah Pratt" ditambahkan',
        time: '13 Okt 2025',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard Admin" />
            <div className="flex flex-1 flex-col gap-6 p-6">
                <Card className="border-dashed">
                    <CardHeader className="gap-2 md:flex-row md:items-start md:justify-between md:gap-6">
                        <div>
                            <Badge variant="secondary" className="mb-2 w-fit uppercase tracking-wide">
                                Selamat datang
                            </Badge>
                            <CardTitle>Website Posting Dasi</CardTitle>
                            <CardDescription>
                                Gunakan dashboard ini sebagai pintu masuk cepat menuju setiap jenis konten edukasi
                                dan layanan konsultasi sesuai flowchart bisnis.
                            </CardDescription>
                        </div>
                        <Button variant="outline" disabled>
                            Lihat Panduan Alur (Coming Soon)
                        </Button>
                    </CardHeader>
                    <CardContent className="grid gap-4 md:grid-cols-3">
                        {activityTimeline.map((item) => (
                            <div
                                key={item.title}
                                className="rounded-xl border border-muted-foreground/10 bg-muted/40 p-4 text-sm"
                            >
                                <p className="font-medium text-foreground">{item.title}</p>
                                <p className="mt-1 text-xs text-muted-foreground">{item.time}</p>
                            </div>
                        ))}
                    </CardContent>
                </Card>

                <div className="grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
                    {resourceCards.map((card) => (
                        <Link key={card.title} href={card.href} className="block focus:outline-none">
                            <Card className={`h-full border ${card.accent} transition hover:-translate-y-0.5 hover:shadow-md`}>
                                <CardHeader>
                                    <div className="flex items-center gap-3 text-lg font-semibold">
                                        <card.icon className="h-6 w-6" />
                                        {card.title}
                                    </div>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-sm text-muted-foreground">{card.description}</p>
                                </CardContent>
                            </Card>
                        </Link>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
