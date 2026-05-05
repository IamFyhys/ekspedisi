<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['users', 'shipments'])->latest()->get();
        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        Branch::create($validated);

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil ditambahkan!');
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', 'Data cabang berhasil diperbarui!');
    }

    public function destroy(Branch $branch)
    {
        // Pengecekan sebelum menghapus agar relasi tidak berantakan
        if ($branch->users()->count() > 0 || $branch->shipments()->count() > 0) {
            return redirect()->route('branches.index')->with('error', 'Tidak bisa menghapus cabang karena masih ada user atau pengiriman yang terkait!');
        }

        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil dihapus!');
    }
}
