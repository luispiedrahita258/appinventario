<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        .titulo{
            text-align: center;
            font: 2rem;
            color: blue
        }
    </style>
</head>
<body>
    <div class="titulo"><h1>Listado de Productos</h1></div>
    <table style="width: 100%;">
        <thead>
        <th>
            <td>Id</td>
            <td>Nombre</td>
            <td>Stock</td>
        </th>
    </thead>
        <tbody>
            @foreach ($productos as $p )
                <tr>
                    <td>{{$p->id}}</td>
                    <td>{{$p->nombre}}</td>
                    <td>{{$p->stock}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
