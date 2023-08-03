<?php

namespace App\Traits;

trait HasToolApiUtility
{
    public function buildResetPasswordUrl(string $token, string $email): string
    {
        return config('api-config.new_password_form_url').'?token='.$token.'?email='.urlencode($email);
    }
}
