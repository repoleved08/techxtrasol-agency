@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    <h1>New Blog Post: {{ $post->title }}</h1>
    <p>{{ $post->excerpt }}</p>

    @component('mail::button', ['url' => route('blog.post', $post->slug)])
        Read Now
    @endcomponent

    <h2>Other Recent Posts</h2>
    <ul>
        @foreach($recentPosts as $recent)
            <li>
                <a href="{{ route('blog.post', $recent->slug) }}">
                    {{ $recent->title }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
