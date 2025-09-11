@extends('layouts.sidebar')
@section('page_title','Nuevo — Vocab record level type')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Vocab record level type</h1>

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

<form method="POST" action="{{ route('vocab-record-level-type.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Type value *</label>
      <input type="text" name="type_value" value="{{ old('type_value', isset($item)? $item->type_value : '') }}" class="input">
    </div>

    <div>
      <label class="label">Description *</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('vocab-record-level-type.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
