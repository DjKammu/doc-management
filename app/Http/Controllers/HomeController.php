<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    CONST INVOICE = 'Rechnung';

    CONST DOC_TYPE = 'Auftrag';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();

        return view('profile',compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        $request->validate([
              'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->save();

        return redirect()->back()->with('message', 'Profile Updated Successfully!');

    }

     public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
             'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }],
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
    
        $user->password = \Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('message', 'Password Updated Successfully!');

    }

}
