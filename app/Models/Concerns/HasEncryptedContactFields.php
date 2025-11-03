<?php

namespace App\Models\Concerns;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

trait HasEncryptedContactFields
{
    protected function address(): Attribute
    {
        return $this->encryptedAttribute();
    }

    protected function whatsappNumber(): Attribute
    {
        return $this->encryptedAttribute();
    }

    protected function issueDescription(): Attribute
    {
        return $this->encryptedAttribute();
    }

    protected function adminNotes(): Attribute
    {
        return $this->encryptedAttribute();
    }

    private function encryptedAttribute(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $this->decryptAttributeValue($value),
            set: fn (?string $value) => $this->encryptAttributeValue($value),
        );
    }

    private function decryptAttributeValue(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $exception) {
            return $value;
        }
    }

    private function encryptAttributeValue(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            Crypt::decryptString($value);

            return $value;
        } catch (DecryptException $exception) {
            return Crypt::encryptString($value);
        }
    }
}
