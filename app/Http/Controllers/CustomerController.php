<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // GET SEARCH PARAMETERS
        $searchTerm = $request->input('q');
        $gender = $request->input('gender');

        // VALIDATE AND SET SORTING PARAMETERS
        $validSortColumns = ['id', 'name', 'email', 'phone', 'address', 'gender', 'date_of_birth'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true)
            ? $request->input('sort_by')
            : 'id';

        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true)
            ? $request->input('sort_direction')
            : 'desc';

        // VALIDATE AND SET PAGINATION LIMIT
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100
            ? (int) $limit
            : 10;

        // INITIALIZE QUERY
        $query = Customer::query();

        // APPLY SEARCH FILTER
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('address', 'like', '%' . $searchTerm . '%');
            });
        }

        // APPLY GENDER FILTER
        if ($gender) {
            $query->where('gender', '=', $gender);
        }

        // APPLY SORTING
        $query->orderBy($sortBy, $sortDirection);

        // EXECUTE PAGINATED QUERY
        $customers = $query->paginate($limit);

        // PRESERVE QUERY PARAMETERS IN PAGINATION LINKS
        $customers->appends([
            'q' => $searchTerm,
            'gender' => $gender,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        // RETURN RESOURCE COLLECTION
        return CustomerResource::collection($customers)
            ->additional([
                'message' => 'Customers retrieved successfully',
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {

        $customerData = [...$request->validated(), 'user_id' => auth()->user()->id];


        $customer = Customer::create($customerData);

        return response()->json(["message" => "customer created successfully", "data" =>  new CustomerResource($customer)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'message' => 'Customer retrieved successfully',
            'data' => new CustomerResource($customer)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {

        $customer->update($request->validated());

        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => new CustomerResource($customer)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}
