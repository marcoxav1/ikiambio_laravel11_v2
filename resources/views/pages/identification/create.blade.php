@extends('layouts.sidebar')
@section('page_title','Nuevo — Identification')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Nuevo — Identification</h1>

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

<form method="POST" action="{{ route('identification.store') }}" class="card card-body">
  @csrf

  <div class="form-grid">

    <div>
      <label class="label">Identificationqualifier</label>
      <input type="text" name="identificationQualifier" value="{{ old('identificationQualifier', isset($item)? $item->identificationQualifier : '') }}" class="input">
    </div>

    <div>
      <label class="label">Typestatus</label>
      <input type="number" name="typeStatus" value="{{ old('typeStatus', isset($item)? $item->typeStatus : '') }}" class="input">
    </div>

    <div>
      <label class="label">Identifiedby</label>
      <input type="text" name="identifiedBy" value="{{ old('identifiedBy', isset($item)? $item->identifiedBy : '') }}" class="input">
    </div>

    <div>
      <label class="label">Dateidentified</label>
      <input type="date" name="dateIdentified" value="{{ old('dateIdentified', isset($item)? $item->dateIdentified : '') }}" class="input">
    </div>

    <div>
      <label class="label">Identificationverificationstatus</label>
      <input type="number" name="identificationVerificationStatus" value="{{ old('identificationVerificationStatus', isset($item)? $item->identificationVerificationStatus : '') }}" class="input">
    </div>

    <div>
      <label class="label">Identificationremarks</label>
      <textarea name="identificationRemarks" class="input" rows="3">{{ old('identificationRemarks', isset($item)? $item->identificationRemarks : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Guardar</button>
    <a href="{{ route('identification.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
