<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ProprtyType;
use App\Models\Property;
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
        $propertyTypes = ProprtyType::count();
        $properties = Property::count();
        $users = User::count();
        $roles = Role::count();

        return view('home',compact('propertyTypes','properties','users','roles'));
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
        
         if($request->hasFile('profile_picture')){
               $profile_picture = $request->file('profile_picture');
               $photoName = $user->name.'-'.time() . '.' . $profile_picture->getClientOriginalExtension();
              
               $avatar  = $request->file('profile_picture')->storeAs('users', $photoName, 'public');

               $user->avatar = $avatar;
        }

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
