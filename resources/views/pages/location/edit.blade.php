@extends('layouts.sidebar')

@section('title','Location — Editar')
@section('page_title','Editar Location')

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('location.update',$item->locationID) }}" class="row g-3">
        @csrf @method('PUT')
        @include('pages.location.partials.form', get_defined_vars())
        <div class="col-12"><button class="btn btn-primary">Actualizar</button>
        <a class="btn btn-outline-secondary" href="{{ route('location.index') }}">Volver</a>
        </div>
      </form>
    </div>
  </div>
@endsection
