<?php

it('has customers/createcustomersapi page', function () {
    $response = $this->get('/customers/createcustomersapi');

    $response->assertStatus(200);
});
