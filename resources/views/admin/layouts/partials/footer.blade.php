


<footer class="bg-dark text-light py-4 mt-4">
    <div class="container text-center">
        {{-- Footer Links --}}
        <div class="mb-3">
            <a href="{{ url('/') }}" class="text-light text-decoration-none me-3">Home</a>
            <a href="{{ url('/about') }}" class="text-light text-decoration-none me-3">About</a>
            <a href="{{ url('/contact') }}" class="text-light text-decoration-none">Contact</a>
        </div>

        {{-- Copyright --}}
        <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </div>
</footer>
