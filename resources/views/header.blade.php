<head><script src="https://cdn.tailwindcss.com"></script>

<header class="bg-gray-800 text-white shadow">
    <div class="container mx-auto flex items-center justify-between py-0 px-3">
        <!-- Logo -->
        <a href="{{ url('/home') }}" class="text-lg font-bold">
            <img src="{{ asset('img/logo1.svg') }}" alt="Logo" class="h-20">
        </a>
        @php
            use App\Http\Controllers\RoleController;
            use Illuminate\Support\Facades\Auth;

            $userid = session('user')->UTI_ID;

            $roleController = new RoleController();
            $role = $roleController->getRole(session('user'));
            print_r($role);
        @endphp
        
        @if($role === 'eleve')
        <!-- Navigation élève -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
            <a href="{{ url('/aptitudes/' . $userid) }}" class="hover:text-gray-400">Bilan de Compétences</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
        </nav>
        @elseif($role === 'responsable')
        <!-- Navigation responsable-->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/createSession') }}" class="hover:text-gray-400">Séances</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Commentaires</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Élèves</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
        </nav>
        @elseif($role === 'initiateur')
        <!-- Navigation initiateur-->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Commentaires</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Élèves</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
        </nav>
        @elseif($role === 'directeur_technique')
        <!-- Navigation directeur technique-->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/formations') }}" class="hover:text-gray-400">Formations</a>
            <a href="{{ url('/createAccount') }}" class="hover:text-gray-400">Comptes</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Élèves</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
        </nav>
        @endif

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-button" class="md:hidden focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Navigation -->
    <!-- Mobile Navigation
    <nav id="mobile-menu" class="md:hidden bg-gray-700 hidden">
        <a href="{{ url('/') }}" class="block px-4 py-2 hover:bg-gray-600">Accueil</a>
        <a href="{{ url('/about') }}" class="block px-4 py-2 hover:bg-gray-600">À propos</a>
        <a href="{{ url('/services') }}" class="block px-4 py-2 hover:bg-gray-600">Services</a>
        <a href="{{ url('/contact') }}" class="block px-4 py-2 hover:bg-gray-600">Contact</a>
    </nav>
     -->
</header>
</head>

<script>
    // Script pour le menu mobile
    document.getElementById('mobile-menu-button').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
