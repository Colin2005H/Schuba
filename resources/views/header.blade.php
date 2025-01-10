<head>
    <script src="https://cdn.tailwindcss.com"></script>

    <header class="bg-white text-black shadow drop-shadow-lg">
        <div class="container mx-auto flex items-center py-2 px-3">
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

            @endphp

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                <i class="fas fa-bars"></i> <!-- Hamburger Icon -->
            </button>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6">
                @if ($role === 'eleve')
                    <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
                    <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
                    <a href="{{ url('/aptitudes/' . $userid) }}" class="hover:text-gray-400">Bilan de Compétences</a>
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
                @elseif($role === 'responsable')
                    <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
                    <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
                    <a href="{{ url('/createSession') }}" class="hover:text-gray-400">Crée Séances</a>
                    <a href="{{ url('/globalAptitudes/' . $teachingLevel) }}" class="hover:text-gray-400">Bilan des
                        Compétences</a>
                    <a href="{{ url('/liste-membres-formation') }}" class="hover:text-gray-400">Membres</a>
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
                @elseif($role === 'initiateur')
                    <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
                    <a href="{{ url('/calendar') }}" class="hover:text-gray-400">Séances</a>
                    <a href="{{ url('/globalAptitudes/' . $teachingLevel) }}" class="hover:text-gray-400">Bilan des
                        Compétences</a>
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
                @elseif($role === 'directeur_technique')
                    <a href="{{ url('/profile') }}" class="hover:text-gray-400">Mon compte</a>
                    <a href="{{ url('/formations') }}" class="hover:text-gray-400">Formations</a>
                    <a href="{{ url('/listUser') }}" class="hover:text-gray-400">Gestions des Utilisateurs</a>
                    <a href="{{ url('/createAccount') }}" class="hover:text-gray-400">Créer Comptes</a>
                    <a href="{{ url('/choisir') }}" class="hover:text-gray-400">Bilan des Compétences</a>
                    <a href="{{ url('/manageAptitudes') }}" class="hover:text-gray-400">Aptitudes</a>
                    <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
                @endif
            </nav>

            <!-- Mobile Navigation (Hidden by default) -->
            <div class="md:hidden" id="mobile-menu"
                class="hidden bg-gray-700 absolute top-0 left-0 w-full h-full z-50 bg-opacity-90">
                <nav class="flex flex-col p-4 bg-gray-50">
                    @if ($role === 'eleve')
                        <a href="{{ url('/profile') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Mon
                            compte</a>
                        <a href="{{ url('/calendar') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Séances</a>
                        <a href="{{ url('/aptitudes/' . $userid) }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Bilan de Compétences</a>
                        <a href="{{ url('/') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Se
                            Déconnecter</a>
                    @elseif($role === 'responsable')
                        <a href="{{ url('/profile') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Mon
                            compte</a>
                        <a href="{{ url('/calendar') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Séances</a>
                        <a href="{{ url('/createSession') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Crée Séances</a>
                        <a href="{{ url('/globalAptitudes/' . $teachingLevel) }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Bilan des Compétences</a>
                        <a href="{{ url('/liste-membres-formation') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Membres</a>
                        <a href="{{ url('/') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Se
                            Déconnecter</a>
                    @elseif($role === 'initiateur')
                        <a href="{{ url('/profile') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Mon
                            compte</a>
                        <a href="{{ url('/calendar') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Séances</a>
                        <a href="{{ url('/globalAptitudes/' . $teachingLevel) }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Bilan des Compétences</a>
                        <a href="{{ url('/') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Se
                            Déconnecter</a>
                    @elseif($role === 'directeur_technique')
                        <a href="{{ url('/profile') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Mon
                            compte</a>
                        <a href="{{ url('/formations') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Formations</a>
                        <a href="{{ url('/listUser') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Gestions des Utilisateurs</a>
                        <a href="{{ url('/createAccount') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Créer Comptes</a>
                        <a href="{{ url('/choisir') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Bilan
                            des Compétences</a>
                        <a href="{{ url('/manageAptitudes') }}"
                            class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Aptitudes</a>
                        <a href="{{ url('/') }}" class="block py-2 px-3 text-gray-900 hover:bg-gray-100">Se
                            Déconnecter</a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <script>
        // Script pour le menu mobile
        document.getElementById('mobile-menu-button').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden'); // Toggle visibility
        });
    </script>
</head>
