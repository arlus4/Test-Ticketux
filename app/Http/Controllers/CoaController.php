<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Kategori;
use App\Http\Requests\CoaRequest;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coas = Coa::with('kategori')->withCount('transaksis')->latest()->get();
        return view('coas.index', compact('coas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('coas.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoaRequest $request)
    {
        Coa::create($request->validated());

        return redirect()->route('coas.index')->with('success', 'COA berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coa $coa)
    {
        $coa->load('kategori', 'transaksis');
        return view('coas.show', compact('coa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coa $coa)
    {
        $kategoris = Kategori::all();
        return view('coas.edit', compact('coa', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoaRequest $request, Coa $coa)
    {
        $coa->update($request->validated());

        return redirect()->route('coas.index')->with('success', 'COA berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coa $coa)
    {
        if ($coa->transaksis()->count() > 0) {
            return redirect()->route('coas.index')->with('error', 'COA tidak dapat dihapus karena masih memiliki transaksi.');
        }

        $coa->delete();

        return redirect()->route('coas.index')->with('success', 'COA berhasil dihapus.');
    }
}
