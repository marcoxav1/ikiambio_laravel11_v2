@extends('layouts.sidebar')

@section('title','Inicio — IKIAM')
@section('page_title','Inicio')

@section('content')
<div class="tiles">
  <a class="tile" href="{{ route('ikiambio-users.index') }}">
    <div class="tile-icon">@include('svg.users')</div>
    <div class="tile-title">Usuarios</div>
  </a>

  <a class="tile" href="#">
    <div class="tile-icon">@include('svg.cap')</div>
    <div class="tile-title">Titulaciones</div>
  </a>

  <a class="tile" href="#">
    <div class="tile-icon">@include('svg.list')</div>
    <div class="tile-title">Materias/Paralelos</div>
  </a>

  <a class="tile" href="#">
    <div class="tile-icon">@include('svg.shield')</div>
    <div class="tile-title">Permisos</div>
  </a>

  <a class="tile" href="#">
    <div class="tile-icon">@include('svg.role')</div>
    <div class="tile-title">Roles</div>
  </a>

  <a class="tile" href="#">
    <div class="tile-icon">@include('svg.admins')</div>
    <div class="tile-title">Usuarios administradores</div>
  </a>
</div>
@endsection
