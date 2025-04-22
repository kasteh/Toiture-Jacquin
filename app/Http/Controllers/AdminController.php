<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Content;
use App\Departement;
use App\Http\Requests\LoginRequest;
use App\User;
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    public function dashboard(){
        $contents = Content::with('category')->orderBy('created_at','DESC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $authUser = auth()->user();
        $users = $authUser->is_admin ? User::orderBy('email','ASC')->get() : null ;
        return view('admin.dashboard',compact('contents','categories','users'));
    }

    public function stats(Request $request){
        $query = $request->query();
        $selectedDepartement = isset($query['departement']) && $query['departement'] != "all" ? $query['departement'] : null;
        $selectedCity = isset($query['city']) && $query['city'] != "all" ? $query['city'] : null;
        $selectedCategory = isset($query['category']) && $query['category'] != "all" ? $query['category'] : null;
        $conditions = [];
        if(!is_null($selectedDepartement)){
            $conditions['departement_id'] = $selectedDepartement;
        }
        if(!is_null($selectedCity)){
            $conditions['city_id'] = $selectedCity;
        }
        if(!is_null($selectedCategory)){
            $conditions['category_id'] = $selectedCategory;
        }
        $visits = Visit::where($conditions)->count();
        $departements = Departement::orderBy('name')->get();
        $cities = City::with('departement')->orderBy('departement_code')->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.stats',compact('visits','departements','cities','categories','selectedDepartement','selectedCity','selectedCategory'));
    }

    public function login(){
        return view('admin.login');
    }

    public function logout(){
        auth()->logout();
        return redirect('/admin/login');
    }

    public function connexion(LoginRequest $request){
        $credentials = $request->only(['email', 'password']);
        if(Auth::attempt($credentials)){
            return redirect('/admin');
        } else {
            $errors = new MessageBag(['password' => ['Mot de passe incorrect']]);
            return redirect()->back()->withInput($request->input())->withErrors($errors);
        }
    }
}
