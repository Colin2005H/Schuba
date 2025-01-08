@extends('head')

@section('title','Formation')

@section('content')
    <h1 class="font-bold">Création de formation</h1>
    <form action="/formations" method="post">
        @csrf

        <label for="category-select">Catégorie&nbsp;:&nbsp;</label>
        <select name="category" id="category-select">
            <option value="">-- Sélectionnez une option --</option>
            <option value="1">N1</option>
            <option value="2">N2</option>
            <option value="3">N3</option>
        </select>

        <label for="manager-select">Responsable&nbsp;:&nbsp;</label>
        <select name="manager" id="manager-select">
            <option value="">-- Sélectionnez une option --</option>
            @foreach($optionsManager as $option)
                <option value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
            @endforeach
        </select>

        <label for="initiator-select">Initiateurs&nbsp;:&nbsp;</label>
        <select name="initiator" id="initiator-select" multiple="multiple">
            @foreach($optionsInitiateur as $option)
                <option value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
            @endforeach
        </select>
        (Pour faire plusieurs choix maintenir la touche CTRL enfoncée)

        <label for="student-select">Élèves&nbsp;:&nbsp;</label>
        <select name="student" id="student-select" multiple="multiple">
            @foreach($optionsStudent as $option)
                <option value="{{ $option->UTI_ID }}">{{ $option->UTI_NOM }} {{ $option->UTI_PRENOM }}</option>
            @endforeach
        </select>
        (Pour faire plusieurs choix maintenir la touche CTRL enfoncée)

        <input type="submit" value="Créer" />

    </form>

    <script>


        document.querySelector('button').addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown-content');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            event.stopPropagation();  // Empêche la propagation du clic pour éviter de fermer le menu immédiatement
        });
    </script>

@endsection




