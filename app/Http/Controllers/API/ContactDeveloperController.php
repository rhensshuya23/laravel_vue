<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Mail\ContactFormDeveloper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactDeveloperController extends Controller
{

	 public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store()
    {
        $data = request()->validate([
    		'name' => 'required',
    		'email' => 'required|email',
    		'issue' => 'required',
    		'message' => 'sometimes',
    	]);

        // send an email 
        Mail::to('abdullah.devexpert@gmail.com')->send(new ContactFormDeveloper($data));

        // session()->flash('message', 'Thanks for your message. We\'ll be in touch!')
        // return redirect('contact-us');

        // or this one line

        // return redirect('contact-us')->with('message', 'Thanks for your message. We\'ll be in touch!');
        return ['message' => 'Successfully sent message'];
    }


}
