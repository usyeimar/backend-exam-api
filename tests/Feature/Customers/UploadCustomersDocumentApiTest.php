<?php

it('has customers/uploadcustomersdocumentapi page', function () {
    $response = $this->get('/customers/uploadcustomersdocumentapi');

    $response->assertStatus(200);
});
