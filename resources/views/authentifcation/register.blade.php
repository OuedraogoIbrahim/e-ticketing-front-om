@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inscription - Pages')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("formAuthentication");

            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                // Nettoyage des erreurs précédentes
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove(
                    'is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                const data = {
                    username: document.getElementById("username").value,
                    email: document.getElementById("email").value,
                    telephone: document.getElementById("phone").value, // Nouveau champ téléphone
                    password: document.getElementById("password").value,
                    password_confirmation: document.getElementById("password_confirmation").value,
                };

                try {
                    const response = await axios.post('{{ env('API_URL') }}/register', data);
                    localStorage.setItem("token-app-e-ticketing", response.data.token);

                    await axios.post('/store-token-in-session', {
                        token: response.data.token,
                        user: response.data.user
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    window.location.href = '/dashboard';
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        for (let field in errors) {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                const div = document.createElement('div');
                                div.classList.add('invalid-feedback');
                                div.innerText = errors[field][0];
                                input.closest('.mb-6').appendChild(div);
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Inscription -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ url('/') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('assets/img/orange-money-logo.jpg') }}" alt="Orange Money Logo"
                                        height="{{ $height ?? 20 }}">
                                </span>
                                <span
                                    class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">L'aventure commence ici 🚀</h4>
                        <p class="mb-6">Rendez la gestion de votre application simple et amusante !</p>

                        <form id="formAuthentication" class="mb-6">
                            @csrf
                            <div class="mb-6">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input autocomplete="off" type="text" class="form-control" id="username" name="username"
                                    placeholder="Entrez votre nom d'utilisateur" autofocus>
                            </div>
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input autocomplete="off" type="text" class="form-control" id="email" name="email"
                                    placeholder="Entrez votre email">
                            </div>
                            <div class="mb-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input autocomplete="off" type="tel" class="form-control" id="phone" name="phone"
                                    placeholder="Entrez votre numéro de téléphone">
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Mot de passe</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="············" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" placeholder="············"
                                        aria-describedby="password_confirmation" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="my-8">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        J'accepte la
                                        <a href="javascript:void(0);">politique de confidentialité et les conditions</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit">S'inscrire</button>
                        </form>

                        <p class="text-center">
                            <span>Vous avez déjà un compte ?</span>
                            <a href="{{ route('login') }}">
                                <span>Se connecter</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Inscription -->
            </div>
        </div>
    </div>
@endsection
