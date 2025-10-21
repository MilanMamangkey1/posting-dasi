import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useForm } from '@inertiajs/react';
import { useEffect } from 'react';

type PublicConsultationFormProps = {
    source: string;
    redirectUrl: string;
    successMessage?: string;
};

const textareaClasses =
    'border-input placeholder:text-muted-foreground focus-visible:ring-ring/50 focus-visible:border-ring focus-visible:ring-[3px] selection:bg-primary selection:text-primary-foreground w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition outline-none disabled:cursor-not-allowed disabled:opacity-50 min-h-[120px]';

export function PublicConsultationForm({ source, redirectUrl, successMessage }: PublicConsultationFormProps) {
    const form = useForm({
        full_name: '',
        address_line: '',
        phone: '',
        notes: '',
        source,
        redirect_url: redirectUrl,
    });

    useEffect(() => {
        form.setData((data) => ({
            ...data,
            source,
            redirect_url: redirectUrl,
        }));
    }, [source, redirectUrl]);

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post('/layanan-konsultasi', {
            preserveScroll: true,
            onSuccess: () => {
                form.setData({
                    full_name: '',
                    address_line: '',
                    phone: '',
                    notes: '',
                    source,
                    redirect_url: redirectUrl,
                });
            },
        });
    };

    return (
        <div className="space-y-4">
            {successMessage && (
                <div className="rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {successMessage}
                </div>
            )}
            <form className="space-y-4" onSubmit={submit}>
                <div className="space-y-2">
                    <label htmlFor="full_name" className="text-sm font-medium text-foreground">
                        Nama Lengkap
                    </label>
                    <Input
                        id="full_name"
                        name="full_name"
                        autoComplete="name"
                        value={form.data.full_name}
                        onChange={(event) => form.setData('full_name', event.target.value)}
                        placeholder="Contoh: Siti Rahma"
                        required
                    />
                    <InputError message={form.errors.full_name} />
                </div>
                <div className="space-y-2">
                    <label htmlFor="address_line" className="text-sm font-medium text-foreground">
                        Alamat Rumah
                    </label>
                    <textarea
                        id="address_line"
                        name="address_line"
                        className={textareaClasses}
                        placeholder="Tuliskan alamat lengkap untuk kebutuhan tindak lanjut."
                        value={form.data.address_line}
                        onChange={(event) => form.setData('address_line', event.target.value)}
                        required
                    />
                    <InputError message={form.errors.address_line} />
                </div>
                <div className="space-y-2">
                    <label htmlFor="phone" className="text-sm font-medium text-foreground">
                        Nomor WhatsApp
                    </label>
                    <Input
                        id="phone"
                        name="phone"
                        autoComplete="tel"
                        value={form.data.phone}
                        onChange={(event) => form.setData('phone', event.target.value)}
                        placeholder="Contoh: 08123456789 atau +628123456789"
                        required
                    />
                    <InputError message={form.errors.phone} />
                </div>
                <div className="space-y-2">
                    <label htmlFor="notes" className="text-sm font-medium text-foreground">
                        Catatan (Opsional)
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        className={textareaClasses}
                        placeholder="Sampaikan pertanyaan singkat atau kebutuhan konsultasi Anda."
                        value={form.data.notes}
                        onChange={(event) => form.setData('notes', event.target.value)}
                    />
                    <InputError message={form.errors.notes} />
                </div>
                <input type="hidden" name="source" value={form.data.source} />
                <input type="hidden" name="redirect_url" value={form.data.redirect_url} />
                <div className="flex items-center justify-end gap-2">
                    <Button
                        type="button"
                        variant="ghost"
                        onClick={() =>
                            form.setData({
                                full_name: '',
                                address_line: '',
                                phone: '',
                                notes: '',
                                source,
                                redirect_url: redirectUrl,
                            })
                        }
                        disabled={form.processing}
                    >
                        Bersihkan
                    </Button>
                    <Button type="submit" disabled={form.processing}>
                        {form.processing ? 'Mengirim...' : 'Kirim Permintaan'}
                    </Button>
                </div>
            </form>
            <p className="text-xs text-muted-foreground">
                Data pribadi Anda hanya digunakan untuk keperluan tindak lanjut konsultasi dan tidak dibagikan ke pihak
                lain.
            </p>
        </div>
    );
}
