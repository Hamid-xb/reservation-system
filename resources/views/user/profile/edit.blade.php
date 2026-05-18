@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <h1>Profiel Pagina</h1>

    <div class="py-12">
        <div class="w-full space-y-6">
            <x-card class="p-4 sm:p-8 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('user.profile.partials.update-profile-information-form')
                </div>
            </x-card>

            <x-card class="p-4 sm:p-8 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('user.profile.partials.update-password-form')
                </div>
            </x-card>

            <x-card class="p-4 sm:p-8 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('user.profile.partials.delete-user-form')
                </div>
            </x-card>
        </div>
    </div>
@endsection