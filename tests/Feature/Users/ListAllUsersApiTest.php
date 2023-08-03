<?php

it('has users/listalluserapi page', function () {
    $response = $this->get('/users/listalluserapi');

    $response->assertStatus(200);
});
