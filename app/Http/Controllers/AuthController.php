<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){ 

        $errors = new MessageBag();

        request()->validate([
            'email' => 'required',
            'password' => 'required|min:3',
        ]);
 

        $credentials = $request->only('email', 'password');
              
        if (Auth::attempt( $credentials ))
        { 

            return redirect('/posts');
        }  
        
        // add your error messages:
        $errors->add('error','Your details aren\'t found!');

        return back()->withErrors($errors);

    }
    
    public function register(Request $request){

        $errors = new MessageBag();
        request()->validate([
            'fullname' => 'required',
            'email' => 'required',
            'password' => 'required|min:3',
            'birth_date' => 'required',
        ]);

        if( $request['password'] != $request['password2']  ){

            $errors->add('error','Please verify your password!');
    
            return back()->withErrors($errors);
        }

        $user = new User;
        
        $user->email = $request['email'];
        $user->fullname = $request['fullname'];
        $user->birth_date = $request['birth_date'];
        $user->password = \Hash::make($request['password']) ;
         
        try {
           $user->save(); 
        } catch (\Throwable $th) {
           
            $errors->add('error','This email already exist!');
    
            return back()->withErrors($errors);
        }
        
        auth()->login($user);
        return redirect('/posts');
    }

    public function logout(){
        auth()->logout();

        return redirect('/');
    }

    public function showAccaunt(){
        return view('admin.settings', [ 'user' => auth()->user() ]);
    }

    public function update(  Request $request ){
        
        $errors = new MessageBag();
        
        request()->validate([
            'fullname' => 'required',
            'email' => 'required', 
            'birth_date' => 'required',
        ]);

        $user = User::findOrFail( auth()->user()->id );

        $user->fullname = $request['fullname'];
        $user->email = $request['email'];
        $user->birth_date = $request['birth_date'];
        
        try {
            $user->update(); 
         } catch (\Throwable $th) {
            
             $errors->add('error','This email already exist!');
     
             return back()->withErrors($errors);
         }

        return back()->with('success', 'Your informations has been updated successfully.');

    }
}



// return view('your-view')->withErrors($errors);