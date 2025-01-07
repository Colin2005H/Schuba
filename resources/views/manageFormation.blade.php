@extends('head')

@section('title','Formation')

@section('content')
    <div class="bg-[rgb(255,255,255,0.8)] px-40 py-10 m-10 justify-items-center rounded">
        <h1 class="font-bold text-[#004B85] text-center text-2xl">Création de formation</h1>
        <form action="/formations" method="post" class="my-6 max-w-96 flex flex-col">
            @csrf
            <div class="flex m-3">
                <label for="category-select" class="font-bold mr-6">Catégorie&nbsp;:&nbsp;</label>
                <select name="category" id="category-select" class="rounded max-w-64 drop-shadow-lg" required>
                    <option value="">-- Sélectionnez une option --</option>
                    <option value="1">N1</option>
                    <option value="2">N2</option>
                    <option value="3">N3</option>
                </select>
            </div>

            <div class="flex m-3">
                <label for="manager-select" class="font-bold mr-6">Responsable&nbsp;:&nbsp;</label>
                <select name="manager" id="manager-select" class="rounded max-w-64 drop-shadow-lg" required>
                    <option value="">-- Sélectionnez une option --</option>
                    @foreach($optionsManager as $option)
                        <option value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex m-3">
                <label for="initiator-select" class="font-bold content-center mr-6">Initiateurs&nbsp;:&nbsp;</label>
                <select name="initiator[]" id="initiator-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                    @foreach($optionsInitiateur as $option)
                        <option value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                    @endforeach
                </select>
            </div>
            <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>

            <div class="flex m-3">
                <label for="student-select" class="font-bold content-center mr-6">Élèves&nbsp;:&nbsp;</label>
                <select name="student[]" id="student-select" multiple="multiple" required class="rounded max-w-64 drop-shadow-lg max-h-12 min-w-48">
                    @foreach($optionsStudent as $option)
                        <option value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
                    @endforeach
                </select>
            </div>
            <p class="text-xs text-center mb-3">(Pour faire plusieurs choix maintenir la touche CTRL enfoncée)</p>

            <div class="text-center m-4">
                <input type="submit" value="Créer" class="bg-[#64DA54] py-2 px-4 rounded text-white" />
            </div>

            @if (session('success'))
                <div class=""> {{ session('success') }} </div>
            @endif

        </form>
    <div>
    <script>


        document.querySelector('button').addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown-content');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            event.stopPropagation();  // Empêche la propagation du clic pour éviter de fermer le menu immédiatement
        });
    </script>

@endsection




