<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PathController extends Controller
{
    public function home()
    {
        return view('website.landing.home');
    }

    public function rooms(){
        return view('website.landing.rooms');
    }

    public function howitworks(){
        return view('website.landing.how-it-works');
    }

    public function contact(){
        return view('website.landing.contact');
    }

    public function submitContact(Request $request)
    {
        // Validate the form data
        $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:500',
        ]);

        // Here you can add logic to:
        // - Send email notification
        // - Save to database
        // - Send to support system
        
        // For now, just redirect back with success message
        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }


}
