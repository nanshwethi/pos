<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // GET SEARCH TERM FROM REQUEST
        $searchTerm = $request->input("q");

        // VALIDATE AND SET SORTING PARAMETERS
        $validSortColumn = ['id', 'title'];

        $sortBy = in_array($request->input('sort_by'), $validSortColumn, true) ? $request->input('sort_by') : "id";

        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        // VALIDATE AND SET PAGINATION LIMIT
        $limit = $request->input('limit', 5);

        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit :  5;

        // INITIALIZE QUERY WITH USER SCOPE
        $query = Category::query();

        // APPLY SEARCH FILTER IF SEARCH TERM EXISTS
        if ($searchTerm) {
            $query->when($searchTerm, function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('slug', 'like', "%{$searchTerm}%");
            });
        }

        //APPLY SORTING PRODUCT
        $query->orderBy($sortBy, $sortDirection);

        // EXECUTE PAGINATED QUERY
        $categories = $query->paginate($limit);

        // PRESERVE ALL QUERY PARAMETERS IN PAGINATION LINKS
        $categories->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);


        return CategoryResource::collection($categories)->additional(["message" => "Categories retrieved successfully"]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $categories = Category::create([
            ...$request->validated(),
            'slug' => Str::slug($request->title),
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => new CategoryResource($categories)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return response()->json([
            'message' => 'Category retrieved successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if (isset($data['title']) &&  $data['title'] !== $category->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        $category->update($data);

        return response()->json([
            'message' => "Category updated successfully",
            'data' => new CategoryResource($category)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $category->delete();

        return response()->json([
            'message' => "Category deleted successfully",
        ]);
    }
}
