@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ mix('css/add_users.css') }}">

<div class="container">
    <h2>{{ __('messages.create_new_user') }}</h2>

    <div class="language-selector mb-3">
    <form action="{{ route('locale.change') }}" method="POST">
    @csrf
    <select name="locale" 
    class="form-select" 
        style="margin-left: 1850px;"
    onchange="this.form.submit()">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
    </select>
</form>
</div>

    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    @if(session('duplicate'))
        <div class="alert alert-warning">
            {{ session('duplicate') }}
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="mb-3 row align-items-center">
    <label for="name" class="col-sm-4 col-form-label text-dark"
    style="font-weight: bold;
    font-size: 1.0rem;"
    >{{ __('messages.name') }}</label>
    <div class="col-sm-8">
        <input type="text" 
         style="margin-left:300px;"
            class="form-control Name1 @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            value="{{ old('name') }}" 
            required 
            placeholder="{{ __('messages.enter_your_name') }}">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>

        <div class="mb-3 row align-items-center"
        style="font-weight: bold;
    font-size: 1.0rem;">
    <label for="phone" class="col-sm-4 col-form-label text-dark">{{ __('messages.phone') }}</label>
    <div class="col-sm-8">
        <input type="text"
         style="margin-left:300px;"
        class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="{{ __('messages.enter_your_phone') }}">
        @error('phone')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
        <div class="mb-3 row align-items-center">
    <label for="national_card_number" 
    
    class="col-sm-4 col-form-label text-dark"
     style="font-weight: bold;
    font-size: 1.0rem;"
    >{{ __('messages.national_card_number') }}</label>
    <div class="col-sm-8">
        <input type="text"
         style="margin-left:300px;"
        class="form-control National1 @error('national_card_number') is-invalid @enderror" id="national_card_number" name="national_card_number" value="{{ old('national_card_number') }}" required placeholder="{{ __('messages.enter_national_card_number') }}">
        @error('national_card_number')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>

        <div class="mb-3 row align-items-center">
    <label for="driving_lincense_number" class="col-sm-4 col-form-label text-dark"
    style="font-weight: bold;
    font-size: 1.0rem;"
    >{{ __('messages.driving_license_number') }}</label>
    <div class="col-sm-8">
        <input type="text" 
        style="margin-left:300px;"
        class="form-control Driving1 @error('driving_lincense_number') is-invalid @enderror" id="driving_lincense_number" name="driving_lincense_number" value="{{ old('driving_lincense_number') }}" required placeholder="{{ __('messages.enter_driving_license_number') }}">
        @error('driving_lincense_number')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
        @foreach (['personal_card_image' => __('messages.upload_personal_card_image'), 'driving_license_image_front' => __('messages.upload_driving_license_image_front'), 'driving_license_image_Back' => __('messages.upload_driving_license_image_back')] as $key => $label)
            <div class="mb-3">
                <label for="path_{{ $key }}" class="form-label">{{ $label }}</label>
                <input type="file" class="form-control @error('path_' . $key) is-invalid @enderror" id="path_{{ $key }}" name="path_{{ $key }}" required style="display: none;" onchange="showSuccess('{{ $key }}')">
                <button type="button" class="btn btn-outline-primary upload" onclick="document.getElementById('path_{{ $key }}').click();"
                    style="{{ $key === 'personal_card_image' ? 'margin-left: 143px;' : '' }}">
                    <i class="bi bi-file-earmark-arrow-up"></i> {{ __('messages.upload_file_image') }}
                </button>
                <span id="success_{{ $key }}" style="color: green; display: none; margin-left: 10px;">
                    <i class="bi bi-check-circle"></i>
                </span>
                @error('path_' . $key)
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <script>
            function showSuccess(key) {
                document.getElementById('success_' + key).style.display = 'inline';
            }
        </script>

        <div class="button-container">
            <button type="submit" class="btn btn-primary">{{ __('messages.create_user') }}</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>

            @if(session('duplicateFound') && session('duplicateUserId'))
                <a class="btn btn-details" href="{{ route('users.detailsUser', ['user' => session('duplicateUserId')]) }}">{{ __('messages.show_details') }}</a>
            @endif

            @if(session('success'))
                <div class="toast" id="toast">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

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

    function hideToast() {
        const toast = document.getElementById('toast');
        if (toast) {
            const bootstrapToast = new bootstrap.Toast(toast);
            bootstrapToast.hide();
        }
    }
</script>

@endsection