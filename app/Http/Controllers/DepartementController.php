<?php

namespace App\Http\Controllers;

use App\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Affiche la liste des departements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $departements = Departement::paginate(20);
        return view('admin.departements.index', compact('departements'));
    }

    /**
     * Affiche le formulaire de création de departements.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.departements.create');
    }

    /**
     * Enregistre un nouveau contenu en base de données.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:departements,code',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:departements,slug',
        ]);

        Departement::create($validated);

        return redirect()->route('admin.departements.index')->with('success', 'Département ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un departement.
     *
     * @param  Departement  $departement
     * @return \Illuminate\View\View
     */
    public function edit(Departement $departement)
    {
        return view('admin.departements.edit', compact('departement'));
    }

    /**
     * Met à jour un contenu existant.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Departement $departement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Departement $departement)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:departements,code,' . $departement->id,
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:departements,slug,' . $departement->id,
        ]);

        $departement->update($validated);

        return redirect()->route('admin.departements.index')->with('success', 'Département mis à jour avec succès.');
    }

    /**
     * Supprime un département existant.
     *
     * @param  Departement  $departement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Departement $departement)
    {
        $departement->delete();

        return redirect()->route('admin.departements.index')->with('success', 'Département supprimé avec succès.');
    }
}
