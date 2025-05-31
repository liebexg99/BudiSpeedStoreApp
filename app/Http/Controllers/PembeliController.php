<?php
namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembeli::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('no_hp', 'like', "%{$search}%");
        }

        $pembelis = $query->paginate(10);
        return view('pembeli.index', compact('pembelis'));
    }

    public function create()
    {
        return view('pembeli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string',
            'no_hp'         => 'required|string|max:15',
        ]);

        Pembeli::create($request->all());
        return redirect()->route('pembeli.index')->with('success', 'Pembeli berhasil ditambahkan!');
    }

    public function show(Pembeli $pembeli)
    {
        return view('pembeli.show', compact('pembeli'));
    }

    public function edit(Pembeli $pembeli)
    {
        return view('pembeli.edit', compact('pembeli'));
    }

    public function update(Request $request, Pembeli $pembeli)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string',
            'no_hp'         => 'required|string|max:15',
        ]);

        $pembeli->update($request->all());
        return redirect()->route('pembeli.index')->with('success', 'Pembeli berhasil diperbarui!');
    }

    public function destroy(Pembeli $pembeli)
    {
        try {
            $pembeli->delete();
            return redirect()->route('pembeli.index')->with('success', 'Pembeli berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pembeli.index')->with('error', 'Gagal menghapus pembeli. Pembeli masih memiliki transaksi!');
        }
    }
}