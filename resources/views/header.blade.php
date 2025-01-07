<header class="bg-gray-800 text-white shadow">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-lg font-bold">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
        </a>
        @Auth
        @if()
        <!-- Navigation élève -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/about') }}" class="hover:text-gray-400">Scéances</a>
            <a href="{{ url('/services') }}" class="hover:text-gray-400">Compétences</a>
            <a href="{{ url('/contact') }}" class="hover:text-gray-400">Se Déconnecter</a>
        </nav>
        @elseif
        <!-- Navigation initiateur/responsable-->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Scéances</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Commentaires</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Élèves</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Se Déconnecter</a>
        </nav>
        @elseif
        <!-- Navigation directeur technique-->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="hover:text-gray-400">Mon compte</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Formations</a>
            <a href="{{ url('/') }}" class="hover:text-gray-400">Comptes</a>
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
    <nav id="mobile-menu" class="md:hidden bg-gray-700 hidden">
        <a href="{{ url('/') }}" class="block px-4 py-2 hover:bg-gray-600">Accueil</a>
        <a href="{{ url('/about') }}" class="block px-4 py-2 hover:bg-gray-600">À propos</a>
        <a href="{{ url('/services') }}" class="block px-4 py-2 hover:bg-gray-600">Services</a>
        <a href="{{ url('/contact') }}" class="block px-4 py-2 hover:bg-gray-600">Contact</a>
    </nav>
</header>

<script>
    // Script pour le menu mobile
    document.getElementById('mobile-menu-button').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
