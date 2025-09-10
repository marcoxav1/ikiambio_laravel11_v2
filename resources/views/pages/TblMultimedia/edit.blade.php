@extends('layouts.sidebar')
@section('page_title','Editar — Tblmultimedia')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Tblmultimedia #{ $item->idMultimedia }</h1>

@if($errors->any())
  <div class="alert alert-danger" style="border:1px solid #fecaca;background:#fee2e2;color:#7f1d1d;">
    <ul class="mb-0">
      @foreach($errors->all() as $e) <li>{ $e }</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('TblMultimedia.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Idregistros</label>
      <input type="text" name="idRegistros" value="{{ old('idRegistros', isset($item)? $item->idRegistros : '') }}" class="input">
    </div>

    <div>
      <label class="label">Type</label>
      <input type="text" name="type" value="{{ old('type', isset($item)? $item->type : '') }}" class="input">
    </div>

    <div>
      <label class="label">Format</label>
      <input type="text" name="format" value="{{ old('format', isset($item)? $item->format : '') }}" class="input">
    </div>

    <div>
      <label class="label">Identifier</label>
      <textarea name="identifier" class="input" rows="3">{{ old('identifier', isset($item)? $item->identifier : '') }}</textarea>
    </div>

    <div>
      <label class="label">Title</label>
      <input type="text" name="title" value="{{ old('title', isset($item)? $item->title : '') }}" class="input">
    </div>

    <div>
      <label class="label">Description</label>
      <textarea name="description" class="input" rows="3">{{ old('description', isset($item)? $item->description : '') }}</textarea>
    </div>

    <div>
      <label class="label">Created</label>
      <input type="date" name="created" value="{{ old('created', isset($item)? $item->created : '') }}" class="input">
    </div>

    <div>
      <label class="label">Creator</label>
      <input type="text" name="creator" value="{{ old('creator', isset($item)? $item->creator : '') }}" class="input">
    </div>

    <div>
      <label class="label">Contributor</label>
      <input type="text" name="contributor" value="{{ old('contributor', isset($item)? $item->contributor : '') }}" class="input">
    </div>

    <div>
      <label class="label">Publisher</label>
      <input type="text" name="publisher" value="{{ old('publisher', isset($item)? $item->publisher : '') }}" class="input">
    </div>

    <div>
      <label class="label">License</label>
      <input type="text" name="license" value="{{ old('license', isset($item)? $item->license : '') }}" class="input">
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('TblMultimedia.index') }}" class="btn">Cancelar</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
  // En edición queremos evitar que borradores del wizard contaminen la vista
  const WIZ_KEYS = [
    'occ_wizard_occurrence_v2',
    'occ_wizard_record_level_v2',
    'occ_wizard_organism_v2',
    'occ_wizard_location_v2',
    'occ_wizard_taxon_v2',
    'occ_wizard_identification_v2',
    'occ_wizard_links_v2',
  ];
  const PREFIX = 'occ_wizard_';

  // 1) Borrar borradores conocidos del wizard
  try { WIZ_KEYS.forEach(k => localStorage.removeItem(k)); } catch {}

  // 2) Parche: mientras estés en esta vista, ignora lecturas/escrituras de esas claves
  (function(ls){
    if (!ls) return;
    const get = ls.getItem.bind(ls);
    const set = ls.setItem.bind(ls);
    const rem = ls.removeItem.bind(ls);

    const isWizardKey = k => typeof k === 'string' && k.startsWith(PREFIX);

    ls.getItem = function(k){ return isWizardKey(k) ? null : get(k); };
    ls.setItem = function(k, v){ if (isWizardKey(k)) return; return set(k, v); };
    // removeItem lo dejamos “normal” por si tu UI necesita limpiar algo explícitamente
    ls.removeItem = function(k){ return rem(k); };
  })(window.localStorage);
})();
</script>
@endpush
