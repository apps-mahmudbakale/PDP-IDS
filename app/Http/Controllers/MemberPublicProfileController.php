<?php

namespace App\Http\Controllers;

use App\Models\Member;

class MemberPublicProfileController extends Controller
{
    /**
     * Display the public member profile
     */
    public function show(string $uuid)
    {
        $member = Member::where('public_uuid', $uuid)->firstOrFail();
        
        return view('members.public-profile', compact('member'));
    }
}
