<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\Member;
use App\Http\Model\User;
use Illuminate\Http\Request;

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
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

        /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
     protected function redirectTo()
     {
        $redirectTo = '/admin/membership';
        if (Auth::user()->role == 2)
        {
            $redirectTo = '/member/landing'; 
            $id = Auth::id();
            $member = Member::select('given','middle','sur','snum','is_life_member','prc_no')->where('prc_no',Auth::user()->prc_no)->first();

            if ($member)
            {
                $fullname = $member->given.' '.$member->middle.' '.$member->sur;
                session(['prc_no'=>$member->prc_no,'fullname'=>$fullname,'snum'=>$member->snum,'islifemember'=>$member->is_life_member]);                    
            }                   
            
        } else
        {
            $redirectTo = '/admin/membership';    
        }
        
        return $redirectTo;
     }

    public function authenticated(Request $request, $user)
    {
        if ($user->verified==0 && $request->token)
        {
            $res = User::where('email',$user->email)->where('verify_token',$request->token)->update(['verified'=>1]);
            if ($res == 0)
            {
              auth()->logout();
              return redirect('/login')->with('warning', 'Your PICE Membership verification token is not valid.');
            }
        } else if ($user->verified==0) {
            auth()->logout();
            return redirect('/login')->with('warning', 'You need PICE Membership approval for your account. Please wait for your activation in your email.');
        }
        //return redirect()->intended($this->redirectPath());
    }
       
    
}
