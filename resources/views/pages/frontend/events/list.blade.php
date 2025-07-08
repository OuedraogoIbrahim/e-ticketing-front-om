@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutFront')

@section('title', 'Liste des evenements')

<!-- Vendor Styles -->
@section('vendor-style')
@endsection

<!-- Page Styles -->
@section('page-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/vendor/libs/spinkit/spinkit.scss', 'resources/assets/js/forms-selects.js'])
@endsection


@section('content')
    @livewire('PublicEvent.Liste')
@endsection
