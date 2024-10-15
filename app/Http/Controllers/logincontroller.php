<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class logincontroller extends Controller
{
    //
    public function index(){
        return view("login");
    }
    
    public function authenticate(Request $request){
        $validator = validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=>'required'
        ]);
        if($validator->passes())
        {
          if(Auth::attempt(['email'=> $request->email,'password'=> $request->password])){
            return redirect()->route('account.dashboard');
          }
          else{
            return redirect()->route('account.login')->with('error','either error or email is incorrect');
          }
        }
        else{
            return redirect()->route('account.login')->withInput()->withErrors($validator);
            //with input atle lidhu jethi form ni value clear na thay
            //with error form ma error display kare
        }
    }

   public function register(){

    return view('register');
   }

   public function ProcessRegister(Request $request){
    $validator=Validator::make($request->all(),[
        'email'=>'required|email|unique:users',
        'password'=> 'required|confirmed'
    ]);

    if($validator->passes()){
        $user=new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role='customer';
        $user->save();

        return redirect()->route('account.login')->with('success','you have register successfully');
    }
    else{
        return redirect()->route('account.login')
        ->withInput()
        ->withErrors($validator);
        
    }
   }

   public function logout(){
     Auth::logout();
     return redirect()->route('account.login');
   }


}
