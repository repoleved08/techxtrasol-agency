<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewsletterConfirmation;
use Illuminate\Contracts\Mail\Mailable;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Check if already subscribed
        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

        if ($subscriber) {
            if ($subscriber->verified_at) {
                return back()->with('newsletter', [
                    'status' => 'info',
                    'message' => 'You are already subscribed to our newsletter!'
                ]);
            }

            // Resend confirmation if not verified
            $this->sendConfirmationEmail($subscriber);
            return back()->with('newsletter', [
                'status' => 'success',
                'message' => 'Confirmation email resent. Please check your inbox.'
            ]);
        }

        // Create new subscriber
        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
            'token' => Str::random(32),
            'user_id' => \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : null // Link to user if authenticated
        ]);

        $this->sendConfirmationEmail($subscriber);

        return back()->with('newsletter', [
            'status' => 'success',
            'message' => 'Please check your email to confirm your subscription.'
        ]);
    }

    public function confirm($token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->firstOrFail();

        if ($subscriber->verified_at) {
            return redirect()->route('home')->with('newsletter', [
                'status' => 'info',
                'message' => 'Your email is already verified.'
            ]);
        }

        $subscriber->update([
            'verified_at' => now(),
            'token' => null
        ]);

        return redirect()->route('home')->with('newsletter', [
            'status' => 'success',
            'message' => 'Thank you for confirming your subscription!'
        ]);
    }

    public function unsubscribe($email)
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->firstOrFail();
        $subscriber->update(['is_active' => false]);

        return redirect()->route('home')->with('newsletter', [
            'status' => 'success',
            'message' => 'You have been unsubscribed from our newsletter.'
        ]);
    }

    protected function sendConfirmationEmail($subscriber)
    {
        Mail::to($subscriber->email)->send(new NewsletterConfirmation($subscriber));
    }
}
