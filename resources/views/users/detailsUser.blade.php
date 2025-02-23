@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ mix('css/user_details.css') }}">

<div class="container_detalis">
<div class="header">
    <a href="{{ route('users.index') }}" class="btn btn-primary icon-button" style="margin-left: 170px;" title="{{ __('messages.back_to_users') }}">
        <i class="bi bi-arrow-left-square"></i>
    </a>

    <h3 style="margin: 0; display: inline-block; margin-left: 280px;">{{ __('messages.details_user') }}</h3>

    <div class="language-selector mb-3" style="margin-left: auto;">
        <form action="{{ route('locale.change') }}" method="POST">
            @csrf
            <select name="locale" class="form-select1" onchange="this.form.submit()">
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
                <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
            </select>
        </form>
    </div>
</div>




    <div class="details">
    <form action="" method="GET" style="display: flex; flex-wrap: wrap; align-items: center; margin-bottom: 20px;">
    <div style="display: flex; align-items: center; margin-right: 130px;">
        <h3 style="margin: 0;">{{ __('messages.id') }}:</h3>
        <span style="margin-left: 5px;">{{ $user->id }}</span>
    </div>

    <div style="display: flex; align-items: center; margin-right: 70px;">
        <h3 style="margin: 0;">{{ __('messages.name') }}:</h3>
        <span style="margin-left: 5px;">{{ $user->translated_name }}</span>
    </div>

    <div style="display: flex; align-items: center; margin-right: 80px;">
        <h3 style="margin: 0; font-weight: bold;">{{ __('messages.phone') }}:</h3>
        <span style="margin-left: 5px;">{{ $user->translated_phone }}</span>
    </div>

    <div style="display: flex; flex-direction: column; align-items: center; margin-right: 10px;">
        @if (!empty($user->path_peronal_card_image) && strpos($user->path_peronal_card_image, '.pdf') !== false)
            <a href="{{ route('downloadperonal_card.pdf', $user->id) }}" style="font-size: 80px; color: red; text-decoration: none; display: flex; align-items: center; margin-bottom: 5px;">
                <i class="fas fa-file-pdf"></i>
            </a>
        @else
            <a href="{{ route('downloadperonal_card.pdf', $user->id) }}" class="btn btn-primary" style="font-size: 80px; color: blue; text-decoration: none; display: flex; align-items: center; margin-bottom: 5px;">
                <i class="bi bi-file-earmark-image"></i>
            </a>
        @endif
        <h5 style="margin: 0;">{{ __('messages.personal_card') }}:</h5>
    </div>
</form>

<div style="display: flex; align-items: center; margin-bottom: 50px;">
    <div style="display: flex; align-items: center; margin-right: 40px;"> 
        <h3 style="margin: 0;">{{ __('messages.national_card_number') }}:</h3>
        <span style="margin-left: 5px;">{{ $user->translated_national_card_number }}</span>
    </div>
    <div style="display: flex; align-items: center; margin-left: 50px;"> 
        <h3 style="margin: 0;">{{ __('messages.driving_license_number') }}:</h3>
        <span style="margin-left: 5px;">{{ $user->translated_driving_license_number }}</span>
    </div>
</div>
        <div style="display: flex; justify-content: center;">
            <div style="display: flex; flex-direction: column; align-items: center; margin-right: 40px;"> 
                @if (!empty($user->path_driving_license_image_front) && strpos($user->path_driving_license_image_front, '.pdf') !== false)
                    <a href="{{ route('download_driving_license_image_front.pdf', $user->id) }}" style="font-size: 80px; color: red; text-decoration: none; display: flex; align-items: center; margin-bottom: 5px; margin-top:26px;">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                @else
                    <a href="{{ route('download_driving_license_image_front.pdf', $user->id) }}" class="btn btn-primary" style="font-size: 80px; color: blue; text-decoration: none; display: flex; align-items: center; margin-bottom: 5px; margin-top:10px;">
                        <i class="bi bi-file-earmark-image"></i>
                    </a>
                @endif
                <h5 style="margin: 0;">{{ __('messages.driving_license_image_front') }}:</h5>
            </div>

            <div style="display: flex; flex-direction: column; align-items: center; margin-left:150px;">
                @if (!empty($user->path_driving_license_image_back) && strpos($user->path_driving_license_image_back, '.pdf') !== false)
                    <a href="{{ route('download_driving_license_image_back.pdf', $user->id) }}" style="font-size: 80px; color: red; text-decoration: none; display: flex; align-items: center; margin-bottom: 5px;">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                @else
                    <a href="{{ route('download_driving_license_image_Back.pdf', $user->id) }}" class="btn btn-primary" style="font-size: 80px; color: blue; text-decoration: none; display: flex; align-items: center; margin-bottom: 5px;">
                        <i class="bi bi-file-earmark-image"></i>
                    </a>
                @endif
                <h5 style="margin: 0;">{{ __('messages.driving_license_image_back') }}:</h5>
            </div>
        </div>
    </div>
</div>
@endsection