<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\Customers\CreateCustomers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CustomerControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
     * Store a newly created resource in storage.
     */
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
     * Display the specified resource.
     */
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
     * Update the specified resource in storage.
     */
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
     * Remove the specified resource from storage.
     */
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
}
