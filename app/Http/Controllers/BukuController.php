<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'penulis'  => 'required',
            'penerbit' => 'required',
            'tahun'    => 'required|numeric',
            'stok'     => 'required|numeric|min:0',
            'gambar'   => 'nullable|image'
        ]);

        $data = $request->only([
            'judul',
            'penulis',
            'penerbit',
            'tahun',
            'stok'
        ]);

        if ($request->hasFile('gambar')) {
            $namaFile = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $namaFile);
            $data['gambar'] = $namaFile;
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    // public function edit(Buku $book)
    // {
    //     return view('books.edit', compact('book'));
    // }

    public function update(Request $request, Buku $buku)
    {
        $buku->update($request->all());
        return redirect()->route('admin.buku.index');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('admin.buku.index');
    }
}
