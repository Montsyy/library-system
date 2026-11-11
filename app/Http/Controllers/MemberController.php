<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
public function index()
    {
        $members = Member::latest()->get();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create', [
            'memberCode' => Member::generateNextMemberCode(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
        ]);

        $validated['member_code'] = Member::generateNextMemberCode();

        Member::create($validated);
        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $member->load(['borrowings.details.book', 'borrowings.user']);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
        ]);

        $member->update($validated);
        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
