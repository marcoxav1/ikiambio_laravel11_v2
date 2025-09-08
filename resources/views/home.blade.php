@extends('layouts.sidebar')

@section('title','Inicio — IKIAM')
@section('page_title','Inicio')

@section('content')
<div class="tiles">
  <a class="tile" href="{{ route('location.index') }}">
    <div class="tile-icon">@include('svg.users')</div>
    <div class="tile-title">LOCATION</div>
  </a>

  <a class="tile" href="{{ route('organism.index') }}">
    <div class="tile-icon">@include('svg.cap')</div>
    <div class="tile-title">ORGANISM</div>
  </a>

  <a class="tile" href="{{ route('taxon.index') }}">
    <div class="tile-icon">@include('svg.list')</div>
    <div class="tile-title">TAXON</div>
  </a>

  <a class="tile" href="{{ route('record-level.index') }}">
    <div class="tile-icon">@include('svg.shield')</div>
    <div class="tile-title">RECORD LEVEL</div>
  </a>

  <a class="tile" href="{{ route('identification.index') }}">
    <div class="tile-icon">@include('svg.role')</div>
    <div class="tile-title">IDENTIFICATION</div>
  </a>

  <a class="tile" href="{{ route('occurrence.index') }}">
    <div class="tile-icon">@include('svg.role')</div>
    <div class="tile-title">OCCURRENCE</div>
  </a>

  <a class="tile" href="#">
    <div class="tile-icon">@include('svg.admins')</div>
    <div class="tile-title">Usuarios administradores</div>
  </a>
</div>
@endsection
