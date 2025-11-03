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
                    $updates = $this->buildEncryptedUpdates(
                        $row->address,
                        $row->whatsapp_number,
                        $row->issue_description,
                        $row->admin_notes,
                        $encrypter
                    );

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
                    $updates = $this->buildEncryptedUpdates(
                        $row->address,
                        $row->whatsapp_number,
                        $row->issue_description,
                        $row->admin_notes,
                        $encrypter
                    );

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

    private function buildEncryptedUpdates(
        ?string $address,
        ?string $number,
        ?string $issueDescription,
        ?string $adminNotes,
        Encrypter $encrypter
    ): array {
        $updates = [];

        $this->setEncryptedValue($updates, 'address', $address, $encrypter);
        $this->setEncryptedValue($updates, 'whatsapp_number', $number, $encrypter);
        $this->setEncryptedValue($updates, 'issue_description', $issueDescription, $encrypter);
        $this->setEncryptedValue($updates, 'admin_notes', $adminNotes, $encrypter);

        return $updates;
    }

    private function setEncryptedValue(array &$updates, string $column, ?string $value, Encrypter $encrypter): void
    {
        if (! $this->shouldEncrypt($value, $encrypter)) {
            return;
        }

        $updates[$column] = $encrypter->encryptString($value);
    }

    private function shouldEncrypt(?string $value, Encrypter $encrypter): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        return ! $this->isEncrypted($value, $encrypter);
    }

    private function isEncrypted(string $value, Encrypter $encrypter): bool
    {
        try {
            $encrypter->decryptString($value);

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
};
