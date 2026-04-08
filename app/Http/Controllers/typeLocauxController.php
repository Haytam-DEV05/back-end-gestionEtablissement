<?php

namespace App\Http\Controllers;

use App\Models\type_locaux;
use Illuminate\Http\Request;
use Redirect;

class typeLocauxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeLocaux = type_locaux::all();
        return view('typeLocaux.index', compact('typeLocaux'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typeLocaux.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_type' => 'required',
        ]);
        type_locaux::create($validated);
        return Redirect()
            ->route('type_locaux.index')
            ->with('success', 'type local creer avec succe');
    }

    /**
     * Display the specified resource.
     */
    public function show(type_locaux $type_locaux)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(type_locaux $type_locaux)
    {
        return view('typeLocaux.edit', compact('type_locaux'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, type_locaux $type_locaux)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(type_locaux $type_locaux)
    {
        $type_locaux->delete();
        return Redirect()
            ->route('type_locaux.index')
            ->with('success', 'supprimer locaux avec succe');
    }
}
