<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin =  Auth::user()->isAdmin();
        if($isAdmin){
            $categories = Category::all();
        }else{
            $categories = Category::query()->whereIn('user_id', [Auth::user()->id])->get();
        }

        return self::successResponse(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth = Auth::user()->id;
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tags')->where(function ($query) use ($auth) {
                $query->where('user_id', $auth);
            })]
        ]);
        $validated['user_id'] = $auth;

        Category::query()->create($validated);

        return self::successResponse(['message' => 'Category created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return self::successResponse(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $auth = Auth::user()->id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tags')->where(function ($query) use ($auth) {
                $query->where('user_id', $auth);
            })->ignore($category->id)]
        ]);
        $category->update($validated);

        return self::successResponse(['message' => 'Category updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return self::successResponse(['message' => 'Category deleted successfully.']);
    }
}
