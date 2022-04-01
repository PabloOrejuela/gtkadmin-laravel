@extends('layouts.template')

@section('title', 'Crear curso')

@section('content')
<div class="container">
    <div class="col col-md-4">
        <h3>Registrar un socio</h3>
        <form action="{{{route("socios.store")}}}" method="POST" class="form-control">
            @csrf
            <div class="mb-3">
                <label for="name">Nombres:</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Nombres" />
                @error('name')
                    <small>*{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" id="exampleFormControlInput1" placeholder="Apellidos" />
                @error('name')
                    <small>*{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="categoria">Categoría:</label>
                <input type="text" name="categoria" value="{{old('categoria')}}" class="form-control" />
                @error('categoria')
                    <small>*{{$message}}</small>
                @enderror
            </div>
            <button type="submit" class="button btn-primary">Enviar</button>
        </form>
    </div>
</div>


@endsection

