<?php

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /** @var Encrypter $encrypter */
        $encrypter = app('encrypter');

        DB::table('consultation_requests')
            ->orderBy('id')
            ->chunkById(100, function ($rows) use ($encrypter): void {
                foreach ($rows as $row) {
                    $updates = $this->buildEncryptedUpdates($row->address, $row->whatsapp_number, $encrypter);

                    if (! empty($updates)) {
                        DB::table('consultation_requests')
                            ->where('id', $row->id)
                            ->update($updates);
                    }
                }
            });

        DB::table('archived_consultation_requests')
            ->orderBy('id')
            ->chunkById(100, function ($rows) use ($encrypter): void {
                foreach ($rows as $row) {
                    $updates = $this->buildEncryptedUpdates($row->address, $row->whatsapp_number, $encrypter);

                    if (! empty($updates)) {
                        DB::table('archived_consultation_requests')
                            ->where('id', $row->id)
                            ->update($updates);
                    }
                }
            });
    }

    public function down(): void
    {
        // Data cannot be reverted to plaintext safely once encrypted.
    }

    private function buildEncryptedUpdates(?string $address, ?string $number, Encrypter $encrypter): array
    {
        $updates = [];

        if ($address !== null && ! $this->isEncrypted($address, $encrypter)) {
            $updates['address'] = $encrypter->encrypt($address);
        }

        if ($number !== null && ! $this->isEncrypted($number, $encrypter)) {
            $updates['whatsapp_number'] = $encrypter->encrypt($number);
        }

        return $updates;
    }

    private function isEncrypted(string $value, Encrypter $encrypter): bool
    {
        try {
            $encrypter->decrypt($value);

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
};
