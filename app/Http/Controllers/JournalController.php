<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journals = Journal::all();

        return self::successResponse(['journals' => $journals]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth = Auth::user()->id;

        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'date'  => ['required','date'],
            'description' => ['required'],
        ]);
        $validated['user_id'] = $auth;

        Journal::query()->create($validated);

        return self::successResponse(['message' => 'Journal created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        return self::successResponse(['journal' => $journal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'date'  => ['required','date'],
            'description' => ['required'],
        ]);

        $journal->update($validated);

        return self::successResponse(['message' => 'Journal updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();
        
        return self::successResponse(['message' => 'Journal deleted successfully.']);
    }
}
