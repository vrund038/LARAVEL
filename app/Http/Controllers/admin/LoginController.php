<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;    

class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=>'required'
        ]);
        if($validator->passes())
        {
          if(Auth::guard('admin')->attempt(['email'=> $request->email,'password'=> $request->password])){
           
            if (Auth::guard('admin')->user()->role != "admin"){
                Auth::guard("admin")->logout();
                return redirect()->route('admin.login')->with('error','You are not Aurthorized to access');
            }

            return redirect()->route('admin.dashboard');
          }
          else{
            return redirect()->route('admin.login')->with('error','either error or email is incorrect');
          }
        }
        else{
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
            //with input atle lidhu jethi form ni value clear na thay
            //with error form ma error display kare
        }
    }


    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

}
