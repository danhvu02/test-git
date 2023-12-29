<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CustomerResource::collection(Customer::performSearch()->paginate()->appends(request()->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
