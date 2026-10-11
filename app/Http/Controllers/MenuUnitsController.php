<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuUnitsResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuUnitsController extends Controller
{
    public function menuUnits()
    {
        $units = Menu::distinct()->pluck('unit');

        return response()->json([
            'message' => 'Menu units retrieved successfully',
            'data' => new MenuUnitsResource($units)
        ]);
    }
}
