<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('kode_pos', 'like', "%{$search}%");
        }

        $suppliers = $query->paginate(10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'kode_pos' => 'required|string|max:10',
        ]);

        Supplier::create($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'kode_pos' => 'required|string|max:10',
        ]);

        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('supplier.index')->with('error', 'Gagal menghapus supplier. Supplier masih digunakan!');
        }
    }
}