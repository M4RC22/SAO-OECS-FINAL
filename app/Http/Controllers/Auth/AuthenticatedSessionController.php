<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Str;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        //Checks if user exists on 'users' table if not then check api
        if(User::where('email', '=', $request->email)->doesntExist()){
            //fetch from dummy user api
            //Get key. if user is not in api = error
            $response = json_decode(Http::get('https://sao-oecs-users.herokuapp.com/users'));
            $key = array_search($request->email, array_column($response, 'email'));

            // // valitdate request
            $request->validate([ 
                'email' =>  [
                    'required',
                    'email',
                    // Rule::unique('user','email'),
                    
                    function($attribute, $value, $fail){
                        $response = json_decode(Http::get('https://sao-oecs-users.herokuapp.com/users'));
                        $key = array_search($value, array_column($response, 'email'));  

                        if($key === false){
                            $fail("These credentials do not match our records.");
                        }
                    }],
                ]
            );

            //create/store fetched
            $getUser = $response[$key+1]; 

            //Checks if user password is equal to stored password in api and if user is professor
            if($getUser->password != $request->password){
                throw ValidationException::withMessages(['errors' => 'These credentials do not match our records.']);
            }elseif($getUser->userType != "Professor"){
                throw ValidationException::withMessages(['errors' => 'Sorry, invalid login.']);
            }else{

                //store user details
                $user = User::create([
                    'first_name' => $getUser->firstName,
                    'middle_name' => $getUser->middleName,
                    'last_name' => $getUser->lastName,
                    'phone_number' => $getUser->phoneNumber,
                    'email' => $getUser->email,
                    'user_type' => $getUser->userType,
                    'password' => bcrypt($getUser->password)
                ]);

                //Attach user to their corresponding department
                $departmentId = DB::table('departments')->where('name', '=', $getUser->departmentName)->pluck('id');
                $user->userStaff()->create([
                    'user_id' => $user->id,
                    'department_id' => $departmentId->first(),
                    'position' => $getUser->departmentPosition,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ]);
            
                $request->authenticate();
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::HOME);
                }
        }else{
            $request->authenticate();
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
