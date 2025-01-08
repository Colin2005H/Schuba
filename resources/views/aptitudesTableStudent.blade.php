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
                <th>SEA_ID</th>
                <th>SEA_DATE_DEB</th>
                <th>UTI_NOM</th>
                <th>APT_CODE</th>
                <th>CPT_ID</th>
                <th>APT_LIBELLE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aptitudesList as $aptitude)
                <tr>
                    <td>{{ $aptitude->SEA_ID }}</td>
                    <td>{{ $aptitude->SEA_DATE_DEB }}</td>
                    <td>{{ $aptitude->UTI_NOM }}</td>
                    <td>{{ $aptitude->APT_CODE }}</td>
                    <td>{{ $aptitude->CPT_ID }}</td>
                    <td>{{ $aptitude->APT_LIBELLE }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
