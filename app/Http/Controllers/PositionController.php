<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PositionController extends Controller
{
    public function index(Request $request): View
    {
        $positions = Position::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('positions.index', [
            'positions' => $positions,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create(): View
    {
        return view('positions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:positions,name'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        Position::create($validated);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function show(Position $position): View
    {
        return view('positions.show', compact('position'));
    }

    public function edit(Position $position): View
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('positions', 'name')->ignore($position->id),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $position->update($validated);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position): RedirectResponse
    {
        $position->update(['status' => 'inactive']);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Data jabatan berhasil dinonaktifkan.');
    }
}
