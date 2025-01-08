<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aptitudes Table Student</title>
</head>
<body>
    <h1>Aptitudes List</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                @foreach($aptitudesList as $aptitude)
                    <th>{{ $aptitude->CPT_ID }}</th>
                @endforeach
            </tr>
            <tr>
                <th></th>
                @foreach($aptitudesList as $aptitude)
                    <th>{{ $aptitude->APT_CODE }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($sessionsList as $session)
                <tr>
                    <th>{{ $session->SEA_DATE_DEB }}</th>
                    @foreach($aptitudesList as $aptitude)
                        @php
                            $found = false; // Drapeau pour savoir si un résultat existe
                        @endphp
                        @foreach($evaluationsList as $evaluation)
                            @if($evaluation->SEA_ID === $session->SEA_ID && $evaluation->APT_CODE === $aptitude->APT_CODE)
                                <td>{{ $evaluation->EVA_RESULTAT }}</td>
                                @php
                                    $found = true; // Résultat trouvé
                                @endphp
                                @break
                            @endif
                        @endforeach

                        @if(!$found)
                            <td></td> <!-- Case vide si aucun résultat -->
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
