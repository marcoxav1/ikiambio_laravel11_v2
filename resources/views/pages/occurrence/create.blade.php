@extends('layouts.sidebar')

@section('title','Occurrence — Crear')
@section('page_title','Crear Occurrence')



@section('content')
<div class="card card-body">
  <form method="POST" action="{{ route('occurrence.store') }}">
    @csrf
    @include('pages.occurrence.partials.form', [
      'item' => $item ?? null,
      'recordLevels' => $recordLevels,
      'oqtypes' => $oqtypes,
      'sexes' => $sexes,
      'lifeStages' => $lifeStages,
      'reproConds' => $reproConds,
      'estabMeans' => $estabMeans,
      'dispositions' => $dispositions,
      // NUEVO:
      'continents' => $continents,
      'verbatimSrs' => $verbatimSrs,
      'georefStatuses' => $georefStatuses,
    ])
    <div class="mt-3">
      <button class="btn btn-primary">Guardar</button>
      <a class="btn btn-outline-secondary" href="{{ route('occurrence.index') }}">Cancelar</a>
    </div>
  </form>
</div>
@endsection
