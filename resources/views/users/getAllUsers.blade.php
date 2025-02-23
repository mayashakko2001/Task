@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ mix('css/styles.css') }}">

<h3 class="w" >{{ __('messages.users') }}</h3>
<div class="header d-flex justify-content-between align-items-center mb-3">
 
   <form class="d-flex" role="search" action="{{ route('users.search') }}" method="GET" >
   <input class="form-control me-2" 
   
   type="search" name="name" placeholder="{{ __('messages.search') }}" aria-label="Search" required style="{{ app()->getLocale() == 'ar' ? 'text-align: right;' : 'text-align: left;' }}">
    <button class="btn btn-outline-success" 
    style="width: 150px;
     border-radius: 0px;
    "
    
    type="submit">{{ __('messages.search') }}</button>
</form>
<div class="language-selector mb-3">
    <!-- Language selection links -->
    <form action="{{ route('locale.change') }}" method="POST">
        @csrf
        <select name="locale" class="form-select" onchange="this.form.submit()">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
            <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
        </select>
    </form>
</div>

<a href="{{ route('users.addUser') }}" class="btn-custom">
    {{ __('messages.new_user') }}
</a>
</div>

@if (session('success'))
    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="position: fixed; bottom: 20px; right: 20px;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="toast-body me-2">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.national_card_number') }}</th>
            <th>{{ __('messages.phone') }}</th>
            <th>{{ __('messages.driving_license_number') }}</th>
            <th>{{ __('messages.operation') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($users) && $users->count() > 0)
            @foreach ($users as $user)
            <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->translated_name }}</td>
            <td>{{ $user->translated_national_card_number }}</td>
            <td>{{ $user->translated_phone }}</td>
            <td>{{ $user->translated_driving_license_number }}</td>
            <td>
            <a href="{{ route('users.detailsUser', $user) }}" class="btn bg-yellow-500 text-white hover:bg-yellow-600">{{ __('messages.details') }}</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-red-600 text-white hover:bg-red-700">{{ __('messages.delete') }}</button>
            </form>
            </td>
            </tr>
            @endforeach
            @else
            <tr>
            <td colspan="6">{{ __('messages.no_users_found') }}</td>
            </tr>
            @endif
            </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast');
        if (toast) {
            const bootstrapToast = new bootstrap.Toast(toast);
            bootstrapToast.show();
            setTimeout(() => {
                bootstrapToast.hide();
            }, 3000); 
        }
    });
</script>

@endsection