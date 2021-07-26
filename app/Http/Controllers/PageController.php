<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;

class PageController extends Controller
{
       /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request,$slug = null)
    {

    if($slug == 'offline-form'){
        $vacancies = Vacancy::where('active',Vacancy::ACTIVE)->paginate((new Vacancy())->perPage);
        return view('offline-form',compact('vacancies'));
    }elseif (view()->exists('static'.'/'.$slug)) {
      return view('static'.'/'.$slug); 
    }
    else{

       abort(404,'somthing went wrong');
    }

  }


  public function contactUs(Request $request)
  {
    $validator  = Validator::make($request->all(), [
      'name'    => 'required',
      'email'   => 'required|email',
      'phone'   => 'required|regex:/^[0-9]{7,15}$/',
      'message' => 'required|min:10'
    ]);


    if($validator->fails()) {
      return redirect('contact')->withErrors($validator)->withInput();
    }


    try {

        Mail::to(config('mail.from.address'))->send(new ContactMail($request));
         return redirect(route('contact'))->with('message', 'Successfully send!! We will contact you soon');

    } catch (\Exception $e) {
        return redirect('contact')->withErrors($e);
    }
  }

}
