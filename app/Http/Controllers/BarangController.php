<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }

        $barangs = $query->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambar   = $request->file('gambar');
            $filename = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/barang', $filename);
            $data['gambar'] = $filename;
        }

        Barang::create($data);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                Storage::delete('public/barang/' . $barang->gambar);
            }

            $gambar   = $request->file('gambar');
            $filename = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/barang', $filename);
            $data['gambar'] = $filename;
        }

        $barang->update($data);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        try {
            if ($barang->gambar) {
                Storage::delete('public/barang/' . $barang->gambar);
            }

            $barang->delete();
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('barang.index')->with('error', 'Gagal menghapus barang. Barang masih digunakan!');
        }
    }
}