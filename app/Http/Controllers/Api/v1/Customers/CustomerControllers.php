<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\UploadCustomerDocumentRequest;
use App\Models\Customer;
use App\OpenApi\SecuritySchemes\ApiAuthorizationTokenSecurityScheme;
use App\Services\Customers\CreateCustomers;
use App\Services\Customers\UploadDocumentForCustomer;
use function base64_encode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CustomerControllers extends Controller
{
    /**
     * Get all customers.
     */
    #[OpenApi\Operation(tags: ['Customers'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function index()
    {
        try {
            return Customer::query()
                ->paginate(10);
        } catch (QueryException $e) {
            abort(400, $e->getMessage());
        }
    }

    /**
     * Create a new customer.
     */
    #[OpenApi\Operation(tags: ['Customers'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function store(CreateCustomerRequest $request, CreateCustomers $createCustomers)
    {
        try {
            return $createCustomers(
                data: $request->validated()
            );
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    /**
     * Get a customer by id.
     */
    #[OpenApi\Operation(tags: ['Customers'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function show(string $id)
    {
        try {
            return Customer::query()
                ->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Not foun this resource with id: '.$id);
        }
    }

    /**
     * Update a customer by id.
     */
    #[OpenApi\Operation(tags: ['Customers'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function update(UpdateCustomerRequest $request, string $id)
    {
        try {
            $customer = Customer::query()
                ->findOrFail($id);

            $customer->fill(
                $request->validated()
            );

            $customer->save();

            return $customer;
        } catch (ModelNotFoundException $e) {
            abort(404, 'Not foun this resource with id: '.$id);
        }
    }

    /**
     * Delete a customer by id.
     */
    #[OpenApi\Operation(tags: ['Customers'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function destroy(string $id)
    {
        try {
            $customer = Customer::query()
                ->findOrFail($id);
            $customer->delete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            abort(404, 'Not foun this resource with id: '.$id);
        }

    }

    /**
     * Upload a document for a customer
     *
     * @param  string  $customerId - The customer id
     * @return JsonResponse|void
     */
    #[OpenApi\Operation(tags: ['Customers'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function uploadDocument(
        string $customerId,
        UploadCustomerDocumentRequest $request,
        UploadDocumentForCustomer $uploadDocumentForCustomer
    ) {
        try {

            if (! $customerId) {
                abort(400, 'Customer id is required');
            }

            $fileName = $customerId.'_'.time().'.'.$request->validated()['document']->getClientOriginalExtension();
            $request->validated()['document']->storePubliclyAs(
                'customers/documents',
                $fileName,
                'public'
            );

            $path = Storage::disk('public')->path('customers/documents/'.$fileName);

            $customer = Customer::query()
                ->findOrFail($customerId);

            $customer->identification_document_base_64 = base64_encode(file_get_contents($path));

            $customer->save();

            return response()->json([
                'success' => true,
                'data' => $customer->fresh(),
            ]);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Not foun this resource with id: '.$customerId);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }
}
