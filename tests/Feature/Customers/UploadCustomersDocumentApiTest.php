<?php

use App\Models\Customer;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('can upload a document for a customer', function () {
    $user = $this->signIn();
    $customer = Customer::factory()->create();
    $data = [
        'document' => UploadedFile::fake()->create('document.pdf'),
    ];

    $response = postJson(route('api.v1.customers.documents.store', $customer->id), $data);

    $response->assertStatus(200);
    assertDatabaseHas('customers', [
        'id' => $customer->id,
        'user_id' => $user->id,
    ]);
});
