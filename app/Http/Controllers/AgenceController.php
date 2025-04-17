<?php

namespace App\Http\Controllers;

use App\Agence;
use App\Category;
use App\City;
use App\Http\Requests\CreateAgenceRequest;
use Illuminate\Http\Request;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryCount = Category::count();
        $headerCategories = Category::all()->random($categoryCount > 4 ? 4 : $categoryCount);
        $headerCities = City::with('departement')->get()->random($categoryCount > 4 ? 4 : $categoryCount);
        $agences = Agence::all();
        return view('agences',compact('headerCategories','headerCities','agences'));
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
        return view('becomePartener',compact('headerCategories','headerCities'));
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
        return redirect()->back()->with('success','Merci, vous êtes maintenant inscrit autant que partenaire.');
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
