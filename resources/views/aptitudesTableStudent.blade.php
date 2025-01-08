<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aptitudes Table Student</title>
</head>
<body>
    <!--@include('header')-->
    <h1>Aptitudes List</h1>

    <table border="1">
        <thead>
            <tr>
            <th>Date</th>
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
                    @if($session->APT_CODE === $aptitude->APT_CODE)
                        <th>{{ $session->EVA_RESULTAT }}</th>
                    @else
                    <th></th>
                    @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
