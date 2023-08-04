<?php

use App\Models\User;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\getJson;

test('can logout', function () {
    $user = User::factory()->create();

    $this->signIn($user);

    getJson(
        route('auth.logout'),
        [
            'device_name' => 'test device',
        ]
    )->assertNoContent();

    assertDatabaseMissing(
        table: 'personal_access_tokens',
        data: [
            'tokenable_id' => $user->id,
        ]
    );
});
