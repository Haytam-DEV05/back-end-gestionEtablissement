<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use Illuminate\Http\Request;
use Pest\Exceptions\TestClosureMustNotBeStatic;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = categorie::all();
        return view('categorie.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formField = $request->validate([
            'nom_categorie' => 'required',
        ]);
        categorie::create($formField);
        return to_route('categorie.index')
            ->with('success', 'category créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categorie $categorie)
    {
        return view('categorie.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, categorie $categorie)
    {
        $formField = $request->validate([
            'nom_categorie' => 'required',
        ]);
        $categorie->update($formField);
        return to_route('categorie.index')
            ->with('success', 'categorie modifier avec succe ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categorie $categorie)
    {
        $categorie->delete();
        return to_route('categorie.index')
            ->with('success', 'categorie supprimer avec succe');
    }
}
