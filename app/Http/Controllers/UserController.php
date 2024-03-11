<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6|confirmed'
        ]);
        //hash password
        $formFields['password'] = bcrypt($formFields['password']);
        User::create($formFields);
        return redirect('/adminpage')->with('success', 'New admin created successfully');
    }

    public function login(){
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/adminpage')->with('success', 'Logged in');
        }
        return back()->withErrors(['email'=>'Wrong email or password'])->onlyInput('email');
    }
}
