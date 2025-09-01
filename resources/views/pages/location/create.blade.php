@extends('layouts.sidebar')

@section('title','Location — Crear')
@section('page_title','Crear Location')

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('location.store') }}" class="row g-3">
        @csrf
        @include('pages.location.partials.form', get_defined_vars())
        <div class="col-12"><button class="btn btn-primary">Guardar</button></div>
      </form>
    </div>
  </div>
@endsection
