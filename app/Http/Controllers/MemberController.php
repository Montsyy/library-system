<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function show($id)
    {
        return 'Member ID: ' . $id;
    }

    public function index()
    {
        $members = [
            'Andi',
            'Buddi',
            'Citra',
            'Dewi',
            'Eko'
        ];
        return view('members.index', compact('members'));
    }
}
