@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Connexion - Pages')

@section('vendor-style')
    {{-- @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss']) --}}
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/bootstrap5.js'])
@endsection

@section('page-script')
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Connexion -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ url('/') }}" class="app-brand-link">
                                <div class="app-brand justify-content-center mb-6">
                                    <a href="{{ url('/') }}" class="app-brand-link">
                                        <span class="app-brand-logo demo">
                                            <img src="{{ asset('assets/img/orange-money-logo.jpg') }}"
                                                alt="Orange Money Logo" height="{{ $height ?? 20 }}">
                                        </span>
                                        <span class="app-brand-text demo text-heading fw-bold">E-ticketing</span>
                                    </a>
                                </div>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Bienvenue sur la plateforme</h4>
                        <p class="mb-6">Veuillez vous connecter à votre compte pour commencer l'aventure</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="formAuthentication" class="mb-4" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="form-label">Email ou Nom d'utilisateur</label>
                                <input type="text" autocomplete="off"
                                    class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="Entrez votre email ou nom d'utilisateur"
                                    autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Mot de passe</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="············" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="my-8">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check mb-0 ms-2">
                                        <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember-me">
                                            Se souvenir de moi
                                        </label>
                                    </div>
                                    {{-- <a href="">
                                        <p class="mb-0">Mot de passe oublié ?</p>
                                    </a> --}}
                                </div>
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-warning d-grid w-100" type="submit">Se connecter</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Nouveau sur notre plateforme ?</span>
                            <a href="{{ route('register') }}">
                                <span>Créer un compte</span>
                            </a>
                        </p>

                        {{-- <div class="divider my-6">
                            <div class="divider-text">ou</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
                                <i class="tf-icons ti ti-brand-facebook-filled"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-twitter me-1_5">
                                <i class="tf-icons ti ti-brand-twitter-filled"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-github me-1_5">
                                <i class="tf-icons ti ti-brand-github-filled"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-google-plus">
                                <i class="tf-icons ti ti-brand-google-filled"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
