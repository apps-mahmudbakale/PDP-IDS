<?php

namespace App\Http\Controllers\Apps\Members;

use App\Enums\MemberCategory;
use App\Http\Controllers\Concerns\ExportsMemberListPdf;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class EstStaffController extends Controller
{
    use ExportsMemberListPdf;

    protected string $category = MemberCategory::EST_STAFF->value;

    /**
     * Whether this category's members must record a department.
     */
    protected function usesDepartment(): bool
    {
        return MemberCategory::tryFrom($this->category)?->usesDepartment() ?? false;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::where('category', $this->category)->get();
        return view('pages.apps.members.est-staff.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.apps.members.est-staff.create');
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
            'department' => $this->usesDepartment()
                ? 'required|string|max:100'
                : 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['category'] = $this->category;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('members', 'public');
        }

        Member::create($validated);

        return redirect()->route('members.est-staff.index')
            ->with('success', "{$this->categoryLabel()} member created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $estStaff)
    {
        if ($estStaff->category !== $this->category) {
            abort(404);
        }
        return view('pages.apps.members.est-staff.show', ['member' => $estStaff]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $estStaff)
    {
        if ($estStaff->category !== $this->category) {
            abort(404);
        }
        return view('pages.apps.members.est-staff.edit', ['member' => $estStaff]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $estStaff)
    {
        if ($estStaff->category !== $this->category) {
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
            'department' => $this->usesDepartment()
                ? 'required|string|max:100'
                : 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('members', 'public');
        }

        $estStaff->update($validated);

        return redirect()->route('members.est-staff.index')
            ->with('success', "{$this->categoryLabel()} member updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $estStaff)
    {
        if ($estStaff->category !== $this->category) {
            abort(404);
        }

        $estStaff->delete();

        return redirect()->route('members.est-staff.index')
            ->with('success', "{$this->categoryLabel()} member deleted successfully.");
    }
}
