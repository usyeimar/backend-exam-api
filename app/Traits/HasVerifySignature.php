<?php

namespace App\Http\Controllers\Api\v1\Traits;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidConfig;

trait HasVerifySignature
{
    public function isValid(Request $request): bool
    {
        $signature = $request->header();

        if (! $signature) {
            return false;
        }

        //   $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw InvalidConfig::signingSecretNotSet();
        }

        $computedSignature = hash_hmac('sha256', $request->getContent(), $signingSecret);

        return hash_equals($signature, $computedSignature);
    }
}
