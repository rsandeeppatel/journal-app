<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin =  Auth::user()->isAdmin();
        if($isAdmin){
            $tags = Tag::all();
        }else{
            $tags = Tag::query()->whereIn('user_id', [Auth::user()->id])->get();
        }

        return self::successResponse(['tags' => $tags]);
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

        Tag::query()->create($validated);

        return self::successResponse(['message' => 'Tag created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return self::successResponse(['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $auth = Auth::user()->id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tags')->where(function ($query) use ($auth) {
                $query->where('user_id', $auth);
            })->ignore($tag->id)]
        ]);
        $tag->update($validated);

        return self::successResponse(['message' => 'Tag updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return self::successResponse(['message' => 'Tag deleted successfully.']);
    }
}
