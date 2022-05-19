<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

class MfaFactor  extends JsonSchema
{
    protected int $minItems = 1;

    protected int $maxItems = 10;

    /**
     * The OTP secret is used with authenticator apps (Google Authenticator, Microsoft Authenticator, Authy, 1Password, LastPass).
     * It must be supplied in un-padded Base32 encoding, such as: JBTWY3DPEHPK3PNP
     */
    protected ?Totp $totp;

    protected ?Phone $phone;

    protected ?Email $email;

    public function totp(?Totp $totp): MfaFactor
    {
        $this->totp = $totp;

        return $this;
    }

    public function phone(?Phone $phone): MfaFactor
    {
        $this->phone = $phone;

        return $this;
    }

    public function email(?Email $email): MfaFactor
    {
        $this->email = $email;

        return $this;
    }

    public function toArray()
    {
        return [
            'totp' => $this->totp,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}