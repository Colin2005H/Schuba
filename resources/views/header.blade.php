<head>
    <script src="https://cdn.tailwindcss.com"></script>

    <header class="bg-white text-black shadow drop-shadow-lg">
        <div class="container mx-auto flex items-center  py-0 px-3">
            <!-- Logo -->
            <a href="{{ url('/home') }}" class="text-lg font-bold">
                <img src="{{ asset('img/logo1.svg') }}" alt="Logo" class="h-20">
            </a>
            <img src="{{ asset('img/Diver.png') }}" alt="diver" class="mr-3">
            @php
                use App\Http\Controllers\RoleController;
                use Illuminate\Support\Facades\Auth;

                $userid = session('user')->UTI_ID;

                $roleController = new RoleController();
                $role = $roleController->getRole(session('user'));
                $teachingLevel = $roleController->getTeachingLevel($userid);
                print_r($role);
            @endphp

            @if ($role === 'eleve')
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
                    <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
                    <a href="{{ url('/globalAptitudes/' . $teachingLevel) }}" class="hover:text-gray-400">Bilan des
                        Compétences</a><!-- listeleves-->
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
                </nav>
            @elseif($role === 'initiateur')
                <!-- Navigation initiateur-->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
                    <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
                    <a href="{{ url('/globalAptitudes/' . $teachingLevel) }}" class="hover:text-gray-400">Bilan des
                        Compétences</a><!-- listeleves-->
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
                </nav>
            @elseif($role === 'directeur_technique')
                <!-- Navigation directeur technique-->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
                    <a href="{{ url('/formations') }}" class="hover:text-gray-400">Formations</a>
                    <a href="{{ url('/createAccount') }}" class="hover:text-gray-400">Gestions des
                        Utilisateurs</a><!-- listUser-->
                    <a href="{{ url('/createAccount') }}" class="hover:text-gray-400">Créer
                        Comptes</a><!-- Create account-->
                    <a href="{{ url('/choisir') }}" class="hover:text-gray-400">Bilan des
                        Compétences</a><!-- PAGE CHOISIR LE NIVEAU-->
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Utilisateurs</a>
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
