<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view("admin.users.index", compact("users"));
    }
    
    private function incrementalHash ($len=10, $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789") {
        $letters = str_split($abc);
        $str = "";
        for ($i=0; $i<=$len; $i++) {
            $str .= $letters[rand(0, count($letters)-1)];
        };
        return $str;
    }

    public function settings(){
        return view('admin.users.settings');
    }

    public function update(ChangePasswordRequest $request){
        $user = auth()->user();
        if(Hash::check($request->old_password,$user->password)){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            auth()->logout();
            return redirect('/admin/login');
        } else {
            $errors = new MessageBag(['old_password' => ['Mot de passe incorrect']]);
            return redirect()->back()->withInput($request->input())->withErrors($errors);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        if(auth()->user()->is_admin){
            $arguments = $request->validated();
            $password = $this->incrementalHash(12);        
            try{
                Mail::send(new NewUserMail([
                    'email' => $arguments['email'],
                    'password' => $password
                ]));
            } catch(Exception $e){
                dd($e->getMessage());
            }
            User::create([
                'email'=>$arguments['email'],
                'password'=> Hash::make($password),
                'is_admin'=> false
            ]);
        }
        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $authUser = auth()->user();
        if($authUser->is_admin && $authUser->id != $user->id){
            $user->delete();
        }        
        return redirect('/admin');
    }
}
