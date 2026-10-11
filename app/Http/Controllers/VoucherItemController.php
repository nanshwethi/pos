<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherItemRequest;
use App\Http\Requests\UpdateVoucherItemRequest;
use App\Models\VoucherItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\VoucherItemExport;
use Maatwebsite\Excel\Facades\Excel;

class VoucherItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     */
    public function show(VoucherItem $voucherItem)
    {
       
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherItemRequest $request, VoucherItem $voucherItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VoucherItem $voucherItem)
    {
        //
    }
}
