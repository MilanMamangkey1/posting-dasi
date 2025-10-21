import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Head, usePage } from '@inertiajs/react';
import { PublicConsultationForm } from '@/components/public-consultation-form';

type PageProps = {
    source: string;
    redirectUrl: string;
    flash?: { success?: string };
};

export default function ConsultationFormPage() {
    const { source, redirectUrl, flash } = usePage<PageProps>().props;

    return (
        <>
            <Head title="Konsultasi WhatsApp" />
            <div className="min-h-screen bg-[#fdfdfc] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#ededec]">
                <div className="mx-auto flex min-h-screen w-full max-w-3xl flex-col justify-center px-6 py-16">
                    <Card className="border border-[#1a1a0014] shadow-sm dark:border-[#fffaed2d]">
                        <CardHeader className="space-y-1">
                            <CardTitle className="text-2xl font-semibold">Formulir Konsultasi</CardTitle>
                            <CardDescription>
                                Isi data berikut untuk terhubung dengan tim kami melalui WhatsApp. Admin akan
                                menghubungi Anda segera setelah permintaan diterima.
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <PublicConsultationForm
                                source={source}
                                redirectUrl={redirectUrl}
                                successMessage={flash?.success}
                            />
                        </CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}

