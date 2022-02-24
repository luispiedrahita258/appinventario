@extends('layouts.main')
@section ('contenido')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal"
        data-bs-target="#ModalAgregar"><i class="fas fa-user"></i> Agregar Usuarios</a>
</div>

<div class="row">
    @if($message = Session::get ('Listo'))
    <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
        <h5>Mensaje: </h5>
        <span>{{$message}}</span>
    </div>
    @endif
    <table class="table col-12">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Nivel</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($usuarios as $usuario )
            <tr>
                <td>{{$usuario->id}}</td>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->email}}</td>
                <td>{{$usuario->nivel}}</td>
                <td>
                    <button class="btn btn-round btnEliminar" data-id="{{ $usuario->id}}" data-bs-toggle="modal"
                        data-bs-target="#ModalEliminar"><i class="fas fa-trash"></i></button>
                        <button class="btn btn-round btnEditar"
                        data-id="{{ $usuario->id}}"
                        data-name="{{ $usuario->name}}"
                        data-email="{{ $usuario->email}}"
                        data-bs-toggle="modal"
                            data-bs-target="#ModalEditar"><i class="fas fa-edit"></i></button>
                    <form action="{{url('/admin/usuarios',['id'=>$usuario->id]) }}" method="POST" id="formEli_{{ $usuario->id}}">
                    @csrf
                    <input type="hidden" name="id" value=" {{$usuario->id}}">
                    <input type="hidden" name="_method" value="delete">
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<!-- Modal Agregar-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/usuarios" method="POST">
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
                        <input type="email" class="form-control" name="email" placeholder="Email"
                            value="{{ old ('email')}}">
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
<script type="text/javascript">
var idEliminar=0;
$(document).ready(function() {
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
</script>
@endsection
