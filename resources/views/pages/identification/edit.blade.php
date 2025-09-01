@extends('layouts.sidebar')
@section('page_title','Editar — Identification')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Identification #{ $item->identificationID }</h1>

@if($errors->any())
  <div class="alert alert-danger" style="border:1px solid #fecaca;background:#fee2e2;color:#7f1d1d;">
    <ul class="mb-0">
      @foreach($errors->all() as $e) <li>{ $e }</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('identification.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

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
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('identification.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection
