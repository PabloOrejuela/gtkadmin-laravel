@extends('layouts.template')

@section('title', 'Socios')

@section('content')
    <h1>Bienvenidos a GTK Ecuador</h1>
    <a href="{{route('socios.registrar')}}">Socios</a>
    <ul>
        @foreach ($socios as $socio)
            <li>
                <a href="{{route('socios.show', $socio->idsocio)}}">{{$socio->nombres}}</a>
            </li>
        @endforeach
    </ul>

    {{$socios->links()}}
@endsection
