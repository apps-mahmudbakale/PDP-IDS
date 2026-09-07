<?php

namespace App\Http\Controllers\Apps\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class NWCController extends Controller
{
    protected string $category = 'NWC';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::where('category', $this->category)->get();
        return view('pages.apps.members.nwc.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.apps.members.nwc.create');
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

        return redirect()->route('members.nwc.index')
            ->with('success', 'NWC member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $nwc)
    {
        if ($nwc->category !== $this->category) {
            abort(404);
        }
        return view('pages.apps.members.nwc.show', ['member' => $nwc]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $nwc)
    {
        if ($nwc->category !== $this->category) {
            abort(404);
        }
        return view('pages.apps.members.nwc.edit', ['member' => $nwc]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $nwc)
    {
        if ($nwc->category !== $this->category) {
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

        $nwc->update($validated);

        return redirect()->route('members.nwc.index')
            ->with('success', 'NWC member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $nwc)
    {
        if ($nwc->category !== $this->category) {
            abort(404);
        }

        $nwc->delete();

        return redirect()->route('members.nwc.index')
            ->with('success', 'NWC member deleted successfully.');
    }
}
