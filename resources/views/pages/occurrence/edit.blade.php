@extends('layouts.sidebar')

@section('title','Occurrence — Editar')
@section('page_title','Editar Occurrence')

@section('content')
<div class="card card-body">
  <form method="POST" action="{{ route('occurrence.update', $item) }}">
    @csrf @method('PUT')
    @include('pages.occurrence.partials.form', [
      'item' => $item ?? null,
      'recordLevels' => $recordLevels,
      'oqtypes' => $oqtypes,
      'sexes' => $sexes,
      'lifeStages' => $lifeStages,
      'reproConds' => $reproConds,
      'estabMeans' => $estabMeans,
      'dispositions' => $dispositions,
      'continents' => $continents,
      'verbatimSrs' => $verbatimSrs,
      'georefStatuses' => $georefStatuses,
    ])
    <div class="mt-3">
      <button class="btn btn-primary">Actualizar</button>
      <a class="btn btn-outline-secondary" href="{{ route('occurrence.index') }}">Volver</a>
    </div>
  </form>
</div>
@endsection
