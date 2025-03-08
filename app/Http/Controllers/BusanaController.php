<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Busana;

class BusanaController extends Controller
{
    public function index()
    {
        $busanas = Busana::all();
        return view('home', compact('busanas'));
    }

    public function create()
    {
        return view('busana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
        ]);

        $busana = new Busana;
        $busana->nama = $request->nama;
        $busana->harga = $request->harga;
        $busana->stok = $request->stok;
        $busana->deskripsi = $request->deskripsi;
        $busana->gambar = $request->gambar;
        $busana->save();

        return redirect()->route('busana.index');
    }

    public function edit($id)
    {
        $busana = Busana::find($id);
        return view('busana.edit', compact('busana'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
        ]);

        $busana = Busana::find($id);
        $busana->nama = $request->nama;
        $busana->harga = $request->harga;
        $busana->stok = $request->stok;
        $busana->deskripsi = $request->deskripsi;
        $busana->gambar = $request->gambar;
        $busana->save();

        return redirect()->route('busana.index');
    }

    public function destroy($id)
    {
        $busana = Busana::find($id);
        $busana->delete();

        return redirect()->route('busana.index');
    }

    public function show($id)
    {
        $busana = Busana::find($id);
        return view('busana.show', compact('busana'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $busana = Busana::where('nama', 'like', "%" . $keyword . "%")->get();
        return view('busana.index', compact('busana'));
    }

    public function filter(Request $request)
    {
        $harga = $request->harga;
        $busana = Busana::where('harga', '<', $harga)->get();
        return view('busana.index', compact('busana'));
    }

    public function sort(Request $request)
    {
        $sort = $request->sort;
        $busana = Busana::orderBy('nama', $sort)->get();
        return view('busana.index', compact('busana'));
    }

    public function paginate(Request $request)
    {
        $paginate = $request->paginate;
        $busana = Busana::paginate($paginate);
        return view('busana.index', compact('busana'));
    }
}
