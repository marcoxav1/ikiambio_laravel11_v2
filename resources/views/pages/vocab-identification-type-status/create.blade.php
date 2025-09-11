@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab identification typestatus')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab identification typestatus</h1>

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

<form method="POST" action="{{ route('vocab-identification-type-status.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Typestatus value *</label>
      <input type="text" name="typeStatus_value" value="{{ old('typeStatus_value', isset($item)? $item->typeStatus_value : '') }}" class="input">
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-identification-type-status.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
