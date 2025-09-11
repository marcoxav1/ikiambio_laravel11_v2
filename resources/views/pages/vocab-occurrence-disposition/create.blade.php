@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab occurrence disposition')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab occurrence disposition</h1>

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

<form method="POST" action="{{ route('vocab-occurrence-disposition.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Disposition value *</label>
      <input type="text" name="disposition_value" value="{{ old('disposition_value', isset($item)? $item->disposition_value : '') }}" class="input">
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-occurrence-disposition.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
