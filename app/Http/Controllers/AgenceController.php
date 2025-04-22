<?php

namespace App\Http\Controllers;

use App\Agence;
use App\Category;
use App\City;
use App\Setting;
use App\Http\Requests\CreateAgenceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Cache, Log, DB};
use App\Helpers\SettingHelper;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer le nombre total de catégories et déterminer la limite
        $categoryCount = Category::count();
        $maxCategories = $categoryCount > 4 ? 4 : $categoryCount;
    
        // Sélectionner un nombre limité de catégories et de villes
        $headerCategories = Category::all()->random($maxCategories);
        $headerCities = City::with('departement')->get()->random($maxCategories);
    
        // Récupérer toutes les agences
        $agences = Agence::all();
    
        // Récupérer l'image héro
        $heroImage = SettingHelper::get('hero_image');
        $aboutFooter = SettingHelper::get('about_footer');
    
        // Passer les variables à la vue
        return view('agences', compact('headerCategories', 'headerCities', 'agences', 'heroImage', 'aboutFooter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryCount = Category::count();
        $headerCategories = Category::all()->random($categoryCount > 4 ? 4 : $categoryCount);
        $headerCities = City::with('departement')->get()->random($categoryCount > 4 ? 4 : $categoryCount);
        $heroImage = SettingHelper::get('hero_image');
        $aboutFooter = SettingHelper::get('about_footer');
        return view('becomePartener',compact('headerCategories','headerCities', 'heroImage', 'aboutFooter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAgenceRequest $request)
    {
        $arguments = $request->validated();
        Agence::create($arguments);
        return redirect()->back()->with('success','Merci, vous êtes maintenant inscrit en tant que partenaire.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agence  $agence
     * @return \Illuminate\Http\Response
     */
    public function show(Agence $agence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agence  $agence
     * @return \Illuminate\Http\Response
     */
    public function edit(Agence $agence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agence  $agence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agence $agence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agence  $agence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agence $agence)
    {
        //
    }
}
