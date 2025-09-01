@extends('layouts.sidebar')

@section('title','Organism — Crear')
@section('page_title','Crear Organism')

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('organism.store') }}" class="row g-3">
        @csrf

        @include('pages.organism.partials.form', ['item' => null])

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary">Guardar</button>
          <a href="{{ route('organism.index') }}" class="btn btn-light">Cancelarrrrrrrrrrrrrr</a>
        </div>
      </form>
    </div>
  </div>
@endsection
