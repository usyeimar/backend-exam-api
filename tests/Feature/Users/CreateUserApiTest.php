<?php

it('has users/createuserapi page', function () {
    $response = $this->get('/users/createuserapi');

    $response->assertStatus(200);
});
