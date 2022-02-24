@extends('layouts.main')
@section ('contenido')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Productos</h1>
    <div class="col-4">
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal"
        data-bs-target="#ModalAgregar"><i class="fas fa-user"></i> Agregar Producto</a>
    <!--Generar PDF-->
        <a href="/admin/productos/imprimir" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print"></i> Imprimir</a>
    </div>
</div>

<div class="row">
    @if($message = Session::get ('Listo'))
    <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
        <h5>Mensaje: </h5>
        <span>{{$message}}</span>
    </div>
    @endif
    <div class="row col-3">
        <canvas id="myChart" width="25" height="25"></canvas><br>
    </div>

    <table class="table col-12">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Codigo</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody id="tbody">

        </tbody>
    </table>
</div>


<!-- Modal Agregar-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/productos" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if($message = Session::get ('ErrorInsert'))
                    <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                        <h5>Errores: </h5>
                        <ul>
                            @foreach($errors->all() as $error)

                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre"
                            value="{{ old ('nombre')}}">
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="img" placeholder="Imagen">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="stock" placeholder="Stock">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="codigo" placeholder="Codigo de Barras">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Datos</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar-->
<div class="modal fade" id="ModalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <h5>¿Desea elimimar el usuario?</h5>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger btnModalEliminar">Eliminar</button>
                </div>
        </div>
    </div>
</div>

<!-- Modal Actualizar-Editar-->
<div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/usuarios/edit" method="POST">
                @csrf
                <div class="modal-body">
                    @if($message = Session::get ('ErrorInsert'))
                    <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                        <h5>Errores: </h5>
                        <ul>
                            @foreach($errors->all() as $error)

                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <input type="hidden" name="id" id="idEdit">
                    <div class="form-group">
                        <input type="text" class="form-control"  name="nombre" id="nameEdit" placeholder="Nombre"
                            value="{{ old('nombre')}}">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="emailEdit" placeholder="Email"
                            value="{{ old('email')}}" >
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass1" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass2" placeholder="Confirmar Contraseña">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

<script type="text/javascript">
var idEliminar=0;
var productos=[];
var valores=[];
$(document).ready(function() {
    $.ajax({
        url: '/admin/productos/all',
        method: 'POST',
        data:{
            id:1,
            _token: $('input[name="_token"]').val()
        }
    }).done(function(res){
        var arreglo = JSON.parse(res);
        for(var x=0;x<arreglo.length;x++){
            var todo='<tr><td>'+arreglo[x].id+'</td>';
            todo+='<td>'+arreglo[x].nombre+'</td>';
            todo+='<td>'+arreglo[x].stock+'</td>';
            todo+='<td>'+arreglo[x].codigo+'</td>';
            todo+='<td></td></tr>';
            $('tbody').append(todo);
            productos.push(arreglo[x].nombre);
            valores.push(arreglo[x].stock);
        }
        generarGrafica();
    });



    @if($message = Session::get('ErrorInsert'))
    $("#ModalAgregar").modal('show');
    @endif
    $(".btnEliminar").click(function(){
        idEliminar = $(this).data('id');
    });
    $(".btnModalEliminar").click(function(){
        $("#formEli_"+idEliminar).submit()
    });
    $(".btnEditar").click(function(){
        $("#idEdit").val($(this).data('id'));
        $("#nameEdit").val($(this).data('name'));
        $("#emailEdit").val($(this).data('email'));
    });
});

function generarGrafica(){
    const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:productos,
            datasets: [{
                label: 'Productos',
                data: valores,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
</script>
@endsection
