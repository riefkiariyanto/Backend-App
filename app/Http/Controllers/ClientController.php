<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function loginHandler(Request $request){

        // return 'hello client login';
    
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        if($fieldType == 'email'){
            $request->validate([
                'login_id'=>'required|email|exists:clients,email',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.email'=>'Invalid email address',
                'login_id.exist'=>'Email is not exist in system',
                'password.required'=>'Password is required'
            ]);
        }else{
            $request->validate([
                'login_id'=>'required|exists:clients,username',
                'password'=>'required|min:5|max:45',
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.exist'=>'Username is not exist in system',
                'password.required'=>'Password is required'
            ]);
        }
    
        $creds = array(
            $fieldType=>$request->login_id,
            'password'=>$request->password
        );
    
        if(Auth::guard('client')->attempt($creds)){
            return redirect()->route('client.home');
        }else{
            session()->flash('fail','Incorrect credentials');
            return redirect()->route('client.login');
        }
       }
}
