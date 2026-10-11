<?php

namespace App\Http\Controllers;

use App\Exports\VoucherExport;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Http\Resources\VoucherDetailResource;
use App\Models\Menu;
use App\Models\Voucher;
use App\Models\VoucherItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\VoucherItemExport;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // GET SEARCH PARAMETERS
        $searchTerm = $request->input('q');

        // DATE FILTER PARAMETERS
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // TYPE FILTER
        $type = $request->input('type');

        // VALIDATE AND SET SORTING PARAMETERS
        $validSortColumns = ['id', 'name', 'email', 'phone', 'address', 'gender', 'date_of_birth', 'created_at'];

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
        $query = Voucher::query();

        // APPLY SEARCH FILTER
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('voucher_number', 'like', "%$searchTerm%")
                    ->orWhereHas('customer', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%$searchTerm%")
                            ->orWhere('phone', 'like', "%$searchTerm%");
                    })
                    ->orWhereHas('voucherItems', function ($q) use ($searchTerm) {
                        $q->where('menu->title', 'like', "%$searchTerm%");
                    });
            });
        }

        // DATE RANGE FILTER
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        if ($type && in_array($type, config("base.sale_type"))) {
            $query->where('type', $type);
        }

        // APPLY SORTING
        $query->orderBy($sortBy, $sortDirection);

        // EXECUTE PAGINATED QUERY
        $vouchers = $query->paginate($limit);

        // PRESERVE QUERY PARAMETERS IN PAGINATION LINKS
        $vouchers->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type' => $type
        ]);

        return VoucherResource::collection($vouchers)
            ->additional([
                'message' => 'Vouchers retrieved successfully',
            ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        try {
            DB::beginTransaction();

            // voucher_times array
            $menuItemCollection = collect($request->validated()['voucher_items']);

            $menus = Menu::whereIn("id", $menuItemCollection->pluck('menu_id')->toArray())->get();

            $voucherItems = [];

            $menuItemCollection->each(function ($item) use ($menus, &$voucherItems) {
                $menu = $menus->firstWhere('id', $item['menu_id']);
                $voucherItems[] = [
                    'menu_id' => $item['menu_id'],
                    'menu' => $menu,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price,
                    'cost' => $menu->price * $item['quantity'],
                    'user_id' => Auth::id()
                ];
            });

            // total, tax, net_total
            $total = collect($voucherItems)->sum('cost');
            $tax = $total * 0.07;
            $netTotal = $total + $tax;

            // store voucher
            $voucher = Voucher::create([
                'customer_id' => $request->validated()['customer_id'] ?? null,
                'date' => $request->validated()['date'],
                'voucher_number' => $request->validated()['voucher_number'],
                'total' => $total,
                'tax' => $tax,
                'net_total' => $netTotal,
                'cash' => $request->validated()['cash'],
                'change' => $request->validated()['change'],
                'voucher_items_count' => count($voucherItems),
                'user_id' => Auth::id(),
                'type' => $request->validated()['type'],
            ]);

            // store voucher_items
            $voucherItems = collect($voucherItems)->map(function ($item) use ($voucher) {
                $item['voucher_id'] = $voucher->id;
                return $item;
            })->toArray();

            VoucherItem::insert($voucherItems);

            DB::commit();

            return response()->json([
                "message" => "Voucher stored successfully"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        return response()->json([
            'message' => 'Voucher retrieved successfully',
            'data' => new VoucherDetailResource($voucher),
        ]);
    }

    //export
    public function excelExport(Request $request)
    {
        return Excel::download(
            new VoucherExport($request),
            'vouchers.xlsx'
        );
    }

    public function voucherItemExport(Request $request)
    {
        return Excel::download(
            new VoucherItemExport($request),
            'voucher_items.xlsx'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
