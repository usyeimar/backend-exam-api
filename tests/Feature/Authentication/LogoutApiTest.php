<?php

use App\Models\User;

test('can logout', function () {
    $user = User::factory()->create();

    $this->signIn($user);

    $this->getJson(
        route('auth.logout'),
        [
            'device_name' => 'test device',
        ]
    )->assertNoContent();

    $this->assertDatabaseMissing(
        table: 'personal_access_tokens',
        data: [
            'tokenable_id' => $user->id,
        ]
    );
});
