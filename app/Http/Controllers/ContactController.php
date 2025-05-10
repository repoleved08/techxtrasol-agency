<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use App\Http\Requests\ContactFormRequest;

class ContactController extends Controller
{
    public function store(ContactFormRequest $request)
    {
        $validated = $request->validated();

        // Send email
        Mail::to('info@techxtrasol.com.com')->send(
            new ContactFormSubmitted($validated)
        );

        return response()->json([
            'message' => 'Thank you for your message! We will get back to you soon.'
        ], 200);
    }
}
