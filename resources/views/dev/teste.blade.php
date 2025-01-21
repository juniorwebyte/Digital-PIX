<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Array Count</th>
                <th>Pagos</th>
                <th>Reservados</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participantes as $participante)
                <tr>
                    <td>{{ $participante->name }}</td>
                    <td>{{ count($participante->numbers()) }}</td>
                    <td>{{ $participante->pagos }}</td>
                    <td>{{ $participante->reservados }}</td>
                    <td>{{ count($participante->numbers()) != $participante->pagos ? 'ERRO' : 'OK' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>