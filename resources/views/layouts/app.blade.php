<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
 
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
