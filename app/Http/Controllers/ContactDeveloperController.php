<?php

namespace App\Http\Controllers;

use App\ContactDeveloper;
use Illuminate\Http\Request;

class ContactDeveloperController extends Controller
{

	 // public function __construct()
  //   {
  //       $this->middleware('auth');
  //   }

    public function store()
    {
        $data = request()->validate([
    		'name' => 'required',
    		'email' => 'required|email',
    		'issue' => 'required',
    		'message' => 'sometimes',
    	]);

        // send an email 
        Mail::to('abdullah.devexpert@gmail.com')->send(new ContactFormMail($data));

        // session()->flash('message', 'Thanks for your message. We\'ll be in touch!')
        // return redirect('contact-us');

        // or this one line

        // return redirect('contact-us')->with('message', 'Thanks for your message. We\'ll be in touch!');
        return ['message' => 'Successfully sent message'];
    }


}
