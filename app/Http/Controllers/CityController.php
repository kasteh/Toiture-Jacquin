<?php

namespace App\Http\Controllers;

use App\City;
use App\Departement;
use Illuminate\Http\Request;

class CityController extends Controller
{
        /**
     * Affiche la liste des departements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cities = City::paginate(20);
        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Affiche le formulaire de création de departements.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $departements = Departement::all();
        return view('admin.cities.create', compact('departements'));
    }

    /**
     * Enregistre un nouveau ville en base de données.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'departement_code' => 'required|string|max:3',
            'slug' => 'required|string|max:255',
            'name_simple' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            
        ]);

        City::create($validated);

        return redirect()->route('admin.cities.index')->with('success', 'Ville ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'une ville.
     *
     * @param  City $city
     * @return \Illuminate\View\View
     */
    public function edit(City $city)
    {
        $departements = Departement::all();
        return view('admin.cities.edit', compact('departements', 'city'));
    }

    /**
     * Met à jour un contenu existant.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'departement_code' => 'required|string|max:3',
            'slug' => 'required|string|max:255',
            'name_simple' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            
        ]);

        $city->update($validated);

        return redirect()->route('admin.cities.index')->with('success', 'Ville mis à jour avec succès.');
    }

    /**
     * Supprime une ville existant.
     *
     * @param  City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'Ville supprimé avec succès.');
    }
}
