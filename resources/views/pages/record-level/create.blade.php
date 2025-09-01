@extends('layouts.sidebar')

@section('title','Record Level — Crear')
@section('page_title','Crear Record Level')

@section('content')
<div class="card card-body">
  <form method="POST" action="{{ route('record-level.store') }}">
    @csrf
    @include('pages.record-level.partials.form')
    <div class="mt-3">
      <button class="btn btn-primary">Guardar</button>
      <a class="btn btn-outline-secondary" href="{{ route('record-level.index') }}">Cancelar</a>
    </div>
  </form>
</div>
@endsection
