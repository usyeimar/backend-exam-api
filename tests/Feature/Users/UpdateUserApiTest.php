<?php

it('has users/updateuserapi page', function () {
    $response = $this->get('/users/updateuserapi');

    $response->assertStatus(200);
});
