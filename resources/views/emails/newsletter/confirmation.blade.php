<x-mail::layout>
    <!-- Header Section -->
    <x-mail::header :url="config('app.url')">
        {{ config('app.name') }}
    </x-mail::header>

    <!-- Main Content -->
    <x-mail::message>
        <!-- Heading -->
        <h1 style="font-size: 24px; color: #333; margin-bottom: 20px;">
            Confirm Your Subscription
        </h1>

        <!-- Body Text -->
        <p style="font-size: 16px; line-height: 1.5; color: #555; margin-bottom: 25px;">
            Thank you for subscribing to our newsletter! Please click the button below to confirm your subscription.
        </p>

        <!-- Primary Action Button -->
        <x-mail::button :url="$url" style="background-color: #4F46E5; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; display: inline-block; font-weight: bold;">
            Confirm Subscription
        </x-mail::button>

        <!-- Secondary Text -->
        <p style="font-size: 14px; color: #777; margin-top: 30px; margin-bottom: 15px;">
            If you didn't request this subscription, you can safely:
        </p>

        <!-- Secondary Action Button -->
        <x-mail::button :url="$unsubscribeUrl" color="light" style="background-color: #F3F4F6; color: #4B5563; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-block; font-weight: medium;">
            Unsubscribe
        </x-mail::button>
    </x-mail::message>

    <!-- Footer Section -->
    <x-mail::footer style="text-align: center; padding: 20px 0; color: #999; font-size: 12px;">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </x-mail::footer>
</x-mail::layout>
