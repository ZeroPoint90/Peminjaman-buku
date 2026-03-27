<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'user')->latest()->get();

        return view('admin.member.index', compact('members'));
    }
}
