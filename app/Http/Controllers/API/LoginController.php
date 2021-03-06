<?php

namespace App\Http\Controllers\API;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Password;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;



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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
          $validator = \Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required'
           ]);

          if ($validator->fails()) {
              return response()->json([
              'status' => 401,
              'message' =>  @$validator->errors()->first()
              ]);
          }

        if (!$this->attemptLogin($request)) {
             return response()->json([
                'status' => 401,
                'message' =>  trans('auth.failed')
             ]);
        }

        $user = $request->user();

       $permissions = @$user->roles[0]['permissions'];
       $is_admin = $user->isAdmin($user);

        $token = \Str::random(60);

        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json([
            'status' => 200,
            'message' =>  'Success',
            'data' =>  [
              'name' => $user->name,  
              'token' => $token,
              'is_admin' => $is_admin,
              'permissions' => $permissions
            ]
        ]);

    }
 

}
