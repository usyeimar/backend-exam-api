<?php

it('has users/deleteuserapi page', function () {
    $response = $this->get('/users/deleteuserapi');

    $response->assertStatus(200);
});
