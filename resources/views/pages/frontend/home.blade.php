@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutFront')

@section('title', 'Landing - Front Pages')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

<!-- Page Styles -->
@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/front-page-landing.js'])
    <script>
        console.log(localStorage.getItem('token-app-e-ticketing'))
    </script>
@endsection


@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative">
                <img src="{{ asset('assets/img/front-pages/backgrounds/hero-bg.png') }}" alt="hero background"
                    class="position-absolute top-0 start-50 translate-middle-x object-fit-cover w-100 h-100" data-speed="1" />
                <div class="container">
                    <div class="hero-text-box text-center position-relative my-5">
                        <h1 class="text-primary hero-title display-6 fw-extrabold">Votre accès aux plus grands événements
                        </h1>
                        <h2 class="hero-sub-title h6 mb-6">
                            Billetterie en ligne sécurisée<br class="d-none d-lg-block" />
                            pour une expérience sans attente
                        </h2>
                    </div>
                    <div id="heroDashboardAnimation" class="hero-animation-img">
                        <a href="{{ route('list.events.index') }}" target="_blank">
                            <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                                <img src="{{ asset('assets/img/front-pages/landing-page/home2.png') }}" alt="hero dashboard"
                                    class="animation-img" data-app-light-img="front-pages/landing-page/home2.png"
                                    data-app-dark-img="front-pages/landing-page/home2.png" width="500" height="500" />
                                <img src="{{ asset('assets/img/front-pages/landing-page/home2.png') }}" alt="hero elements"
                                    class="position-absolute hero-elements-img animation-img top-0 start-0"
                                    data-app-light-img="front-pages/landing-page/home2.png"
                                    data-app-dark-img="front-pages/landing-page/home2.png" width="500" height="500" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="landing-hero-blank"></div>
        </section>
        <!-- Hero: End -->
    </div>
@endsection
