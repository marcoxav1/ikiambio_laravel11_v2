@extends('layouts.sidebar')

@section('title','Record Level — Editar')
@section('page_title','Editar Record Level')

@section('content')
<div class="card card-body">
  <form method="POST" action="{{ route('record-level.update', $item) }}">
    @csrf @method('PUT')
    @include('pages.record-level.partials.form', ['item' => $item])
    <div class="mt-3">
      <button class="btn btn-primary">Actualizar</button>
      <a class="btn btn-outline-secondary" href="{{ route('record-level.index') }}">Volver</a>
    </div>
  </form>
</div>
@endsection
