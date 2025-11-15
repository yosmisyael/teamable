<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $positions = Position::query()->withCount('employees')->orderBy('nama_jabatan')->get();

        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:positions,nama_jabatan',
            'gaji_pokok' => 'required|decimal:0,2|min:0|max:99999999.99',
        ]);

        Position::query()->create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $position = Position::query()->findOrFail($id);

        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $position = Position::query()->findOrFail($id);

        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jabatan' => [
                'required',
                'string',
                'max:100',
                Rule::unique('positions', 'nama_jabatan')->ignore($id),
            ],
            'gaji_pokok' => 'required|decimal:0,2|min:0|max:99999999.99',
        ]);

        Position::query()->findOrFail($id)->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Position::query()->findOrFail($id)->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position with ID ' . $id . ' has been deleted successfully');
    }
}
