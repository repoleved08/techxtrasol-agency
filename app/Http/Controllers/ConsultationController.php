<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationMail;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'service' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store consultation
        $consultation = Consultation::create($validated);

        // Send email to you
        Mail::to(config('mail.from.address'))->send(new ConsultationMail($consultation));

        return redirect()->back()->with('success', 'Consultation submitted successfully.');

    }
}
