<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class PassportRevokerHelper
{
    private User $user;

    private function __construct($user)
    {
        $this->user = $user;
    }

    public static function create(User $user): PassportRevokerHelper
    {
        return new self(
            user: $user
        );
    }

    /**
     * It revokes by updating only the token in database, that is given when user do a login.
     */
    public function revokeOnlyCurrentToken(): void
    {
        $this->user->token()->revoke();
    }

    /**
     * It revoke by updating all tokens of the user when user logout, it keeps them on database.
     */
    public function revokeAllTokens(): void
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $this->user->id)
            ->update([
                'revoked' => true,
            ]);
    }

    /**
     * It deletes the current token in database, the token deleted is the one used by the user use to login.
     */
    public function deleteCurrentToken(): ?bool
    {
        return $this->user->token()->delete();
    }

    /**
     * It deletes all tokens in database used by the user when user logout.
     */
    public function deleteAllTokens(): void
    {
        $this->user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }
}
