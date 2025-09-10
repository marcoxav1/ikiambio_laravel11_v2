@extends('layouts.sidebar')
@section('page_title','Editar — Event')

@section('content')
<h1 class="h4" style="margin:0 0 12px 0;">Editar — Event #{ $item->eventID }</h1>

@if($errors->any())
  <div class="alert alert-danger" style="border:1px solid #fecaca;background:#fee2e2;color:#7f1d1d;">
    <ul class="mb-0">
      @foreach($errors->all() as $e) <li>{ $e }</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('event.update', $item) }}" class="card card-body">
  @csrf @method('PUT')

  <div class="form-grid">

    <div>
      <label class="label">Parenteventid</label>
      <input type="text" name="parentEventID" value="{{ old('parentEventID', isset($item)? $item->parentEventID : '') }}" class="input">
    </div>

    <div>
      <label class="label">Eventdate</label>
      <input type="date" name="eventDate" value="{{ old('eventDate', isset($item)? $item->eventDate : '') }}" class="input">
    </div>

    <div>
      <label class="label">Eventtime</label>
      <input type="time" name="eventTime" value="{{ old('eventTime', isset($item)? $item->eventTime : '') }}" class="input">
    </div>

    <div>
      <label class="label">Year</label>
      <input type="number" name="year" value="{{ old('year', isset($item)? $item->year : '') }}" class="input">
    </div>

    <div>
      <label class="label">Month</label>
      <input type="number" name="month" value="{{ old('month', isset($item)? $item->month : '') }}" class="input">
    </div>

    <div>
      <label class="label">Day</label>
      <input type="number" name="day" value="{{ old('day', isset($item)? $item->day : '') }}" class="input">
    </div>

    <div>
      <label class="label">Habitat</label>
      <textarea name="habitat" class="input" rows="3">{{ old('habitat', isset($item)? $item->habitat : '') }}</textarea>
    </div>

    <div>
      <label class="label">Samplingprotocol</label>
      <textarea name="samplingProtocol" class="input" rows="3">{{ old('samplingProtocol', isset($item)? $item->samplingProtocol : '') }}</textarea>
    </div>

    <div>
      <label class="label">Fieldnotes</label>
      <textarea name="fieldNotes" class="input" rows="3">{{ old('fieldNotes', isset($item)? $item->fieldNotes : '') }}</textarea>
    </div>

    <div>
      <label class="label">Locationid</label>
      <input type="text" name="locationID" value="{{ old('locationID', isset($item)? $item->locationID : '') }}" class="input">
    </div>

    <div>
      <label class="label">Eventremarks</label>
      <textarea name="eventRemarks" class="input" rows="3">{{ old('eventRemarks', isset($item)? $item->eventRemarks : '') }}</textarea>
    </div>
  </div>

  <div style="margin-top:12px;">
    <button class="btn primary">Actualizar</button>
    <a href="{{ route('event.index') }}" class="btn">Cancelar</a>
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
