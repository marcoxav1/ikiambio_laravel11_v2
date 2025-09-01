@extends('layouts.sidebar')

@section('title','Taxon — Editar')
@section('page_title','Editar Taxon')

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('taxon.update',$item->taxonID) }}" class="row g-3">
        @csrf @method('PUT')

        @include('pages.taxon.partials.form', [
          'item' => $item,
          'taxonRanks' => $taxonRanks,
          'taxonomicStatuses' => $taxonomicStatuses,
        ])

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary">Actualizar</button>
          <a href="{{ route('taxon.index') }}" class="btn btn-light">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
