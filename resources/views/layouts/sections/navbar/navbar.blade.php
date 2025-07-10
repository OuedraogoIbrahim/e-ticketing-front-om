@php
    use Illuminate\Support\Facades\Route;
    $containerNav = $configData['contentLayout'] === 'compact' ? 'container-xxl' : 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
    $user = session()->get('auth_user');

@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
            <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-md"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    <div class="navbar-nav align-items-center flex-row gap-2">
        <!-- Lien Accueil -->
        <div class="nav-item me-2">
            <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
                <i class="ti ti-home ti-md me-1"></i>
                <span class="d-none d-sm-inline">Accueil</span>
            </a>
        </div>
    </div>


    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/placeholder-user.jpg') }}" alt class="rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item mt-0"
                        href="{{ Route::has('profile.show') ? route('profile.show') : 'javascript:void(0);' }}">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-2">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('assets/img/placeholder-user.jpg') }}" alt
                                        class="rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">
                                    {{ $user['username'] }}
                                </h6>
                                <small class="text-muted">{{ $user['role'] }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1 mx-n2"></div>
                </li>
                {{-- <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">Profile</span>
                    </a>
                </li> --}}

                {{-- <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 ti ti-file-dollar me-3 ti-md"></i><span
                                class="flex-grow-1 align-middle">Billing</span>
                            <span
                                class="flex-shrink-0 badge bg-danger d-flex align-items-center justify-content-center">4</span>
                        </span>
                    </a>
                </li> --}}

                <li>
                    <div class="dropdown-divider my-1 mx-n2"></div>
                </li>
                <li>
                    <div class="d-grid px-2 pt-2 pb-1">
                        <button class="btn btn-sm btn-danger d-flex" onclick="handleLogout()">
                            <small class="align-middle">Se déconnecter</small>
                            <i class="ti ti-logout ms-2 ti-14px"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->

<script script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    async function handleLogout() {
        const authToken = localStorage.getItem('token-app-e-ticketing');

        try {
            await axios.post('{{ env('API_URL') }}/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                }
            });

            // 2. Nettoyage des sessions côté serveur (Laravel)
            await axios.post('{{ route('clear-session') }}', {}, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // 3. Nettoyage côté client
            localStorage.removeItem('token-app-e-ticketing');
            sessionStorage.clear();

            // 4. Redirection
            window.location.href = '/login';

        } catch (error) {
            console.error('Déconnexion échouée:', error);
            // Fallback: forcer la déconnexion
            // window.location.href = '/login?force_logout=1';
        }
    }
</script>
