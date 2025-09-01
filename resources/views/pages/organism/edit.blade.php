@extends('layouts.sidebar')

@section('title','Organism — Editar')
@section('page_title','Editar Organism')

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('organism.update',$item->organismID) }}" class="row g-3">
        @csrf @method('PUT')

        @include('pages.organism.partials.form', ['item' => $item])

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary">Actualizar</button>
          <a href="{{ route('organism.index') }}" class="btn btn-light">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
