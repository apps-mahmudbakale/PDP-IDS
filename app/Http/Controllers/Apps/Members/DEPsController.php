<?php

namespace App\Http\Controllers\Apps\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class DEPsController extends Controller
{
    protected string $category = 'DEP';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::where('category', $this->category)->get();
        return view('pages.apps.members.deps.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.apps.members.deps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:50',
            'surname' => 'required|string|max:100',
            'firstname' => 'required|string|max:100',
            'middlename' => 'nullable|string|max:100',
            'position' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'state' => 'nullable|string|max:100',
            'pscode' => 'nullable|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['category'] = $this->category;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('members', 'public');
        }

        Member::create($validated);

        return redirect()->route('members.deps.index')
            ->with('success', 'DEP member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $dep)
    {
        if ($dep->category !== $this->category) {
            abort(404);
        }
        return view('pages.apps.members.deps.show', ['member' => $dep]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $dep)
    {
        if ($dep->category !== $this->category) {
            abort(404);
        }
        return view('pages.apps.members.deps.edit', ['member' => $dep]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $dep)
    {
        if ($dep->category !== $this->category) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:50',
            'surname' => 'required|string|max:100',
            'firstname' => 'required|string|max:100',
            'middlename' => 'nullable|string|max:100',
            'position' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'state' => 'nullable|string|max:100',
            'pscode' => 'nullable|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('members', 'public');
        }

        $dep->update($validated);

        return redirect()->route('members.deps.index')
            ->with('success', 'DEP member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $dep)
    {
        if ($dep->category !== $this->category) {
            abort(404);
        }

        $dep->delete();

        return redirect()->route('members.deps.index')
            ->with('success', 'DEP member deleted successfully.');
    }
}
