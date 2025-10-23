<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Pengajuan Konsultasi Baru</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f7fafc; color: #1a202c; }
            .container { max-width: 560px; margin: 0 auto; padding: 24px; background: #ffffff; border-radius: 12px; }
            h1 { font-size: 20px; margin-bottom: 16px; color: #2d3748; }
            dl { margin: 0; }
            dt { font-weight: bold; margin-top: 12px; color: #4a5568; }
            dd { margin: 0; color: #2d3748; }
            .footer { margin-top: 24px; font-size: 12px; color: #718096; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Pengajuan Konsultasi Baru</h1>
            <p>Halo, terdapat pengajuan konsultasi baru dari website Posting Dasi.</p>
            <dl>
                <dt>Nama</dt>
                <dd>{{ $consultation->full_name }}</dd>
                <dt>Nomor WhatsApp</dt>
                <dd>{{ $consultation->whatsapp_number }}</dd>
                <dt>Alamat</dt>
                <dd>{{ $consultation->address }}</dd>
                <dt>Deskripsi Permasalahan</dt>
                <dd style="white-space: pre-line;">{{ $consultation->issue_description }}</dd>
                <dt>Waktu Pengajuan</dt>
                <dd>{{ $consultation->created_at->timezone(config('app.timezone'))->format('d M Y H:i') }}</dd>
            </dl>
            <p class="footer">Email ini dikirim otomatis oleh sistem Posting Dasi.</p>
        </div>
    </body>
</html>
