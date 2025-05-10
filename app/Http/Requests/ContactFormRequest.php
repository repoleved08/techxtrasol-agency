<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'privacy' => 'accepted',
            'g-recaptcha-response' => ['required', new \App\Rules\Recaptcha]
        ];
    }

    public function messages()
    {
        return [
            'privacy.accepted' => 'You must agree to the privacy policy'
        ];
    }
}
