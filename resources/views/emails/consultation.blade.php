@component('mail::message')
# New Consultation Request

**Name:** {{ $consultation->name }}
**Email:** {{ $consultation->email }}
**Phone:** {{ $consultation->phone ?? 'N/A' }}
**Service:** {{ $consultation->service }}

**Message:**
{{ $consultation->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
