<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = $request->query('search');
        $query = Department::query();
        if ($keyword) {
            $query->where('nama_departemen', 'like', "%{$keyword}%");
        }
        $departments = $query->latest()
            ->paginate(10)
            ->withQueryString();
        return view('departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departments',
        ]);
        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'Departemen baru berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('departments.edit', $id);
    }
    public function edit(string $id): View
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }
    public function update(Request $request, string $id): RedirectResponse
    {
        $department = Department::findOrFail($id);
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departments,nama_departemen,' . $department->id,
        ]);
        $department->update($request->all());
        return redirect()->route('departments.index')->with('success', 'Data departemen berhasil diperbarui.');
    }


    public function destroy(string $id): RedirectResponse
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
