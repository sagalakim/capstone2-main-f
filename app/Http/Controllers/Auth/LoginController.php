<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Hash;
use App\Models\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    

    public function login(Request $request){

        /*
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return response()->noContent();
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    */






        /*
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)){
                
                return response()->json(['status' => true, 'message' => 'Success']);
            }
                return response()->json(['status' => false, 'message' => 'Fail']);
            */
        
        
        //    BEST WORKING
            $input = $request->all();
            $this->validate($request,[
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            if(auth()->attempt(['email' =>$input["email"], 'password'=>$input['password']])){

                if(auth()->user()->role == 'general_admin'){
                    return redirect()->route('home.general_admin');
                    //return response()->json(['status' => true, 'user' => $user, 'message' => 'Success']);
                }
                else if(auth()->user()->role == 'executive_assistant'){
                    return redirect()->route('home.executive_assistant');
                    //return response()->json(['status' => true, 'message' => 'Success']);
                }
                else if(auth()->user()->role == 'nsm_nl'){
                    return redirect()->route('home.nsmnl');
                    //return response()->json(['status' => true, 'message' => 'Success']);
                }
                else if(auth()->user()->role == 'nsm_fl'){
                    return redirect()->route('home.nsmfl');
                    //return response()->json(['status' => true, 'message' => 'Success']);
                }
                else if(auth()->user()->role == 'asm'){
                    return redirect()->route('home.asm');
                    //return response()->json(['status' => true, 'message' => 'Success']);
                }
                else if(auth()->user()->role == 'rsm'){
                    return redirect()->route('home.rsm');
                    //return response()->json(['status' => true, 'message' => 'Success']);
                }
                else{
                    return redirect()->route('home');
                    //return response()->json(['status' => true, 'message' => 'I am regular Agent', 'user' => $user]);
                }
            }
            else{
                return redirect()->route("login")->with("error",'Incorrect email or password');
                
            }
            //
            
            
    }
}
