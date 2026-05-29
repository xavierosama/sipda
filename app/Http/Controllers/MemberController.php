<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Member;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $members = Member::query()
            ->with(['department', 'position'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('full_name', 'like', '%'.$request->search.'%')
                        ->orWhere('name', 'like', '%'.$request->search.'%')
                        ->orWhere('phone', 'like', '%'.$request->search.'%')
                        ->orWhere('email', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->where('department_id', $request->department_id);
            })
            ->when($request->filled('position_id'), function ($query) use ($request) {
                $query->where('position_id', $request->position_id);
            })
            ->when($request->filled('member_status'), function ($query) use ($request) {
                $query->where('member_status', $request->member_status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', [
            'members' => $members,
            'departments' => $this->departmentOptions(),
            'positions' => $this->positionOptions(),
            'filters' => $request->only(['search', 'department_id', 'position_id', 'member_status']),
        ]);
    }

    public function create(): View
    {
        return view('members.create', [
            'member' => new Member(),
            'departments' => $this->departmentOptions(),
            'positions' => $this->positionOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMember($request);

        Member::create($this->memberPayload($validated));

        return redirect()
            ->route('members.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function show(Member $member): View
    {
        $member->load(['department', 'position']);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        return view('members.edit', [
            'member' => $member,
            'departments' => $this->departmentOptions(),
            'positions' => $this->positionOptions(),
        ]);
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $this->validateMember($request, $member);

        $member->update($this->memberPayload($validated));

        return redirect()
            ->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->update([
            'member_status' => 'inactive',
            'status' => 'inactive',
        ]);

        return redirect()
            ->route('members.index')
            ->with('success', 'Data anggota berhasil dinonaktifkan.');
    }

    private function validateMember(Request $request, ?Member $member = null): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'member_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('members', 'member_number')->ignore($member?->id),
            ],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('members', 'email')->ignore($member?->id),
            ],
            'joined_at' => ['nullable', 'date'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'member_status' => ['required', Rule::in(['active', 'inactive'])],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function memberPayload(array $validated): array
    {
        return [
            ...$validated,
            'name' => $validated['full_name'],
            'place_of_birth' => $validated['birth_place'] ?? null,
            'date_of_birth' => $validated['birth_date'] ?? null,
            'status' => $validated['member_status'],
        ];
    }

    private function departmentOptions()
    {
        return Department::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    private function positionOptions()
    {
        return Position::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }
}
