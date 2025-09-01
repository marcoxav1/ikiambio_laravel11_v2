@extends('layouts.sidebar')
@section('page_title','Editar — Vocab record level type')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Vocab record level type #{ $item->type_id }</h1>

@if($errors->any())
  <div class="alert alert-danger" style="border:1px solid #fecaca;background:#fee2e2;color:#7f1d1d;">
    <ul class="mb-0">
      @foreach($errors->all() as $e) <li>{ $e }</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('vocab-record-level-type.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

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
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('vocab-record-level-type.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
