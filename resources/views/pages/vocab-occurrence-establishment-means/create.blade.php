@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab occurrence establishmentmeans')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab occurrence establishmentmeans</h1>

@if (session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('vocab-occurrence-establishment-means.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Estabmeans value *</label>
      <input type="text" name="estabmeans_value" value="{{ old('estabmeans_value', isset($item)? $item->estabmeans_value : '') }}" class="input">
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-occurrence-establishment-means.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
