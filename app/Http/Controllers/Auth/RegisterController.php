<?php

namespace App\Http\Controllers\Auth;

use App\Http\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'member/landing';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        $messages = [
          'password.regex' => 'Passwords must contain a special character i.e. !$@&#%  and a number.',
        ];
        
        return Validator::make($data, [
            'given' => 'required|string|max:100',
            'sur' => 'required|string|max:100',            
            'prc_no' => 'required|unique:users|min:1',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$@&#%]).*$/|min:6|confirmed',
        ], $messages );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        $result = DB::table('membership')->selectRaw('prc_no, count(prc_no) mem_count')
        ->where('prc_no',$data['prc_no'])
        ->where('is_deleted',0)
        ->groupBy('prc_no')->first();
        
        $mem_count = 0;

        if ($result)
        {
            $mem_count = $result->mem_count;
        }
        
        return User::create([
                'given' => strtoupper(trim($data['given'])),
                'sur' => strtoupper(trim($data['sur'])),
                'middle' => strtoupper(trim($data['middlename'])),
                'prc_no' => $data['prc_no'],
                'email' => $data['email'],
                'mem_count' => $mem_count,
                'password' => Hash::make($data['password']),
            ]);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'Thank you for registering to our Membership Portal. PICE Administrator will validate your membership access.');
    }
}
