<?php

test('send forgot password email', function () {
    $user = $this->signIn();
    $response = $this->postJson(route('auth.forgot-password'), [
        'email' => $user->email,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'success',
        'message',
    ]);
});

test('send forgot password email with invalid email', function () {
    $response = $this->postJson(route('auth.forgot-password', ['email' => 'invalid']));
    $response->assertStatus(422);
    $response->assertJsonStructure([
        'errors' => [
            [
                'title',
                'detail',
            ],
        ],
    ]);
});
