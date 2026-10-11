<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        
        // VALIDATE AND SET SORTING PARAMETERS
        $validSortColumns = ['id', 'created_at'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true)
            ? $request->input('sort_by')
            : 'id';

        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true)
            ? $request->input('sort_direction')
            : 'desc';

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100
            ? (int) $limit
            : 10;

        $onlyAvailable = $request->input('only_available',false);
       
        $query = Banner::query()->with('user');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($onlyAvailable) {
            $query->where('is_available', true);
        }

        $query->orderBy($sortBy, $sortDirection);

        $banners = $query->paginate($limit);

        $banners->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return BannerResource::collection($banners)
            ->additional([
                'message' => 'Banners retrieved successfully',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $banner = Banner::create([...$request->validated(), 'user_id' => auth()->user()->id]);
        return response()->json([
            "message" => "Banner created successfully",
            "data" => $banner
        ]);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return response()->json([
            "message" => "Banner retrieved successfully",
            "data" => new BannerResource($banner)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $banner->update($request->validated());
        return response()->json([
            "message" => "Banner updated successfully",
            "data" => $banner
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return response()->json([
            "message" => "Banner deleted successfully"
        ]);
    }
}
