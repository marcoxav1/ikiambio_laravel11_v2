{{-- resources/views/pages/occurrence/create_wizard.blade.php --}}

@extends('layouts.sidebar')

@section('title','Crear Occurrence — Wizard')

@section('content')
<div class="container-xxl">
  <h1 class="mb-3">Nueva Occurrence (Wizard)</h1>

  {{-- Navegación por pestañas --}}
  <ul class="nav nav-tabs" id="occTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="tab-occurrence-tab" data-bs-toggle="tab"
              data-bs-target="#tab-occurrence" type="button" role="tab">
        1) Occurrence
      </button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-record-level-tab" data-bs-toggle="tab"
              data-bs-target="#tab-record-level" type="button" role="tab">
        2) Record level
      </button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-organism-tab" data-bs-toggle="tab"
              data-bs-target="#tab-organism" type="button" role="tab">
        3) Organism
      </button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-location-tab" data-bs-toggle="tab"
              data-bs-target="#tab-location" type="button" role="tab">
        4) Location
      </button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-taxon-tab" data-bs-toggle="tab"
              data-bs-target="#tab-taxon" type="button" role="tab">
        5) Taxon
      </button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab-identification-tab" data-bs-toggle="tab"
              data-bs-target="#tab-identification" type="button" role="tab">
        6) Identification
      </button>
    </li>
  </ul>

  <div class="tab-content border-start border-end border-bottom p-3">
    {{-- ============ TAB 1: OCCURRENCE (SOLO CAMPOS PROPIOS) ============ --}}
    <div class="tab-pane fade show active" id="tab-occurrence" role="tabpanel">
      <form id="occ-form" method="POST" action="{{ route('occurrence.store') }}">
        @csrf

        {{-- ***** IDs ocultos que se rellenan desde otras pestañas ***** --}}
        <input type="hidden" name="record_level_id" id="record_level_id" value="{{ old('record_level_id') }}">
        <input type="hidden" name="organismID"       id="organismID"       value="{{ old('organismID') }}">
        <input type="hidden" name="locationID"       id="locationID"       value="{{ old('locationID') }}">
        <input type="hidden" name="taxonID"          id="taxonID"          value="{{ old('taxonID') }}">
        <input type="hidden" name="identificationID" id="identificationID" value="{{ old('identificationID') }}">

        {{-- Resumen de selección actual --}}
        <div class="alert alert-secondary small" role="alert">
          <div class="mb-1 fw-bold">Selecciones vinculadas:</div>
          <div>Record level: <span id="summary-rl">—</span></div>
          <div>Organism: <span id="summary-org">—</span></div>
          <div>Location: <span id="summary-loc">—</span></div>
          <div>Taxon: <span id="summary-tax">—</span></div>
          <div>Identification: <span id="summary-id">—</span></div>
        </div>

        {{-- ===== Campos propios de OCCURRENCE ===== --}}
        <div class="row g-3">
          <div class="col-md-4">
            <label class="label" for="occurrenceID">OccurrenceID</label>
            <input type="text" name="occurrenceID" id="occurrenceID" class="input"
                   value="{{ old('occurrenceID') }}"
                   placeholder="Ingrese su OccurrenceID">
            @error('occurrenceID') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="catalogNumber">Catalog Number</label>
            <input type="text" name="catalogNumber" id="catalogNumber" class="input"
                   value="{{ old('catalogNumber') }}">
            @error('catalogNumber') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="recordNumber">Record Number</label>
            <input type="text" name="recordNumber" id="recordNumber" class="input"
                   value="{{ old('recordNumber') }}">
            @error('recordNumber') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="recordedBy">Recorded By</label>
            <input type="text" name="recordedBy" id="recordedBy" class="input"
                   value="{{ old('recordedBy') }}">
            @error('recordedBy') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="individualCount">Individual Count</label>
            <input type="number" name="individualCount" id="individualCount" class="input"
                   value="{{ old('individualCount') }}">
            @error('individualCount') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="organismQuantity">Organism Quantity</label>
            <input type="number" step="any" name="organismQuantity" id="organismQuantity" class="input"
                   value="{{ old('organismQuantity') }}">
            @error('organismQuantity') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Vocabs obligatorias de Occurrence --}}
          <div class="col-md-4">
            <label class="label" for="organismQuantityType">Organism Quantity Type *</label>
            <select name="organismQuantityType" id="organismQuantityType" class="input">
              <option value="">— Selecciona —</option>
              @foreach($oqtypes as $opt)
                <option value="{{ $opt->oqtype_id }}" @selected(old('organismQuantityType') == $opt->oqtype_id)>
                  {{ $opt->oqtype_value }}@if($opt->description) — {{ \Illuminate\Support\Str::limit($opt->description,50) }}@endif
                </option>
              @endforeach
            </select>
            @error('organismQuantityType') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="sex">Sex *</label>
            <select name="sex" id="sex" class="input">
              <option value="">— Selecciona —</option>
              @foreach($sexes as $opt)
                <option value="{{ $opt->sex_id }}" @selected(old('sex') == $opt->sex_id)>
                  {{ $opt->sex_value }}
                </option>
              @endforeach
            </select>
            @error('sex') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="lifeStage">Life stage *</label>
            <select name="lifeStage" id="lifeStage" class="input">
              <option value="">— Selecciona —</option>
              @foreach($lifeStages as $opt)
                <option value="{{ $opt->lifestage_id }}" @selected(old('lifeStage') == $opt->lifestage_id)>
                  {{ $opt->lifestage_value }}
                </option>
              @endforeach
            </select>
            @error('lifeStage') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="reproductiveCondition">Reproductive condition *</label>
            <select name="reproductiveCondition" id="reproductiveCondition" class="input">
              <option value="">— Selecciona —</option>
              @foreach($reproConds as $opt)
                <option value="{{ $opt->reprocond_id }}" @selected(old('reproductiveCondition') == $opt->reprocond_id)>
                  {{ $opt->reprocond_value }}
                </option>
              @endforeach
            </select>
            @error('reproductiveCondition') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="establishmentMeans">Establishment means *</label>
            <select name="establishmentMeans" id="establishmentMeans" class="input">
              <option value="">— Selecciona —</option>
              @foreach($estabMeans as $opt)
                <option value="{{ $opt->estabmeans_id }}" @selected(old('establishmentMeans') == $opt->estabmeans_id)>
                  {{ $opt->estabmeans_value }}
                </option>
              @endforeach
            </select>
            @error('establishmentMeans') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="disposition">Disposition *</label>
            <select name="disposition" id="disposition" class="input">
              <option value="">— Selecciona —</option>
              @foreach($dispositions as $opt)
                <option value="{{ $opt->disposition_id }}" @selected(old('disposition') == $opt->disposition_id)>
                  {{ $opt->disposition_value }}
                </option>
              @endforeach
            </select>
            @error('disposition') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- Textos largos --}}
          <div class="col-12">
            <label class="label" for="behavior">Behavior</label>
            <textarea name="behavior" id="behavior" rows="2" class="input">{{ old('behavior') }}</textarea>
            @error('behavior') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="substrate">Substrate</label>
            <textarea name="substrate" id="substrate" rows="2" class="input">{{ old('substrate') }}</textarea>
            @error('substrate') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="preparations">Preparations</label>
            <textarea name="preparations" id="preparations" rows="2" class="input">{{ old('preparations') }}</textarea>
            @error('preparations') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="associatedMedia">Associated media</label>
            <textarea name="associatedMedia" id="associatedMedia" rows="2" class="input">{{ old('associatedMedia') }}</textarea>
            @error('associatedMedia') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="associatedSequences">Associated sequences</label>
            <textarea name="associatedSequences" id="associatedSequences" rows="2" class="input">{{ old('associatedSequences') }}</textarea>
            @error('associatedSequences') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="associatedTaxa">Associated taxa</label>
            <textarea name="associatedTaxa" id="associatedTaxa" rows="2" class="input">{{ old('associatedTaxa') }}</textarea>
            @error('associatedTaxa') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="otherCatalogNumbers">Other catalog numbers</label>
            <textarea name="otherCatalogNumbers" id="otherCatalogNumbers" rows="2" class="input">{{ old('otherCatalogNumbers') }}</textarea>
            @error('otherCatalogNumbers') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-12">
            <label class="label" for="occurrenceRemarks">Occurrence remarks</label>
            <textarea name="occurrenceRemarks" id="occurrenceRemarks" rows="2" class="input">{{ old('occurrenceRemarks') }}</textarea>
            @error('occurrenceRemarks') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-success">Guardar Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 2: RECORD LEVEL (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-record-level" role="tabpanel">
      <form id="rl-form" action="{{ route('ajax.record-levels.store') }}" method="POST">
        @csrf
        @include('pages.record-level.partials.form', [
          'item'                 => null,
          'types'                => $types,
          'licenses'             => $licenses,
          'rightsHolders'        => $rightsHolders,
          'accessRights'         => $accessRights,
          'institutionIds'       => $institutionIds,
          'collectionIds'        => $collectionIds,
          'institutionCodes'     => $institutionCodes,
          'collectionCodes'      => $collectionCodes,
          'ownerInstitutionCodes'=> $ownerInstitutionCodes,
          'basisOfRecords'       => $basisOfRecords,
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 3: ORGANISM (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-organism" role="tabpanel">
      <form id="organism-form">
        @csrf
        @include('pages.organism.partials.form', ['item' => null])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 4: LOCATION (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-location" role="tabpanel">
      <form id="location-form">
        @csrf
        @include('pages.location.partials.form', [
          'item'           => null,
          'continents'     => $continents ?? collect(),
          'verbatimSrs'    => $verbatimSrs ?? collect(),
          'georefStatuses' => $georefStatuses ?? collect(),
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 5: TAXON (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-taxon" role="tabpanel">
      <form id="taxon-form">
        @csrf
        @include('pages.taxon.partials.form', [
          'item'              => null,
          'taxonRanks'        => $taxonRanks ?? collect(),
          'taxonomicStatuses' => $taxonomicStatuses ?? collect(),
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>

    {{-- ============ TAB 6: IDENTIFICATION (FORM PROPIO) ============ --}}
    <div class="tab-pane fade" id="tab-identification" role="tabpanel">
      <form id="identification-form">
        @csrf
        @include('pages.identification.partials.form', [
          'item'             => null,
          'idTypeStatuses'   => $idTypeStatuses ?? collect(),
          'idVerifStatuses'  => $idVerifStatuses ?? collect(),
        ])
        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar y usar en Occurrence</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
(function () {
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Helpers
  async function postForm(form, url, onOk) {
    const fd = new FormData(form);
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: fd
    });
    if (!res.ok) { alert('Error al guardar'); return; }
    const data = await res.json();
    if (typeof onOk === 'function') onOk(data.id, data);
  }

  function showTabOccurrence() {
    const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
    if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
  }

  function setHiddenAndSummary(inputId, value, summaryId, label) {
    const $in = document.getElementById(inputId);
    if ($in) $in.value = value;
    const $sum = document.getElementById(summaryId);
    if ($sum) $sum.textContent = label || value || '—';
  }

  // 1) Record level
  const rlForm = document.getElementById('rl-form');
  if (rlForm) {
    rlForm.addEventListener('submit', function (e) {
      e.preventDefault(); // <-- evita refresco
      postForm(rlForm, rlForm.action, function (id, data) {
        setHiddenAndSummary('record_level_id', id, 'summary-rl', data.label || ('#'+id));
        alert('Record level guardado y asignado: ' + id);
        showTabOccurrence();
      });
    });
  }
  // 2) Organism
  const orgForm = document.getElementById('organism-form');
  if (orgForm) {
    orgForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(orgForm, @json(route('ajax.organisms.store')), function (id, data) {
        setHiddenAndSummary('organismID', id, 'summary-org', data.label || id);
        alert('Organism guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }

  // 3) Location
  const locForm = document.getElementById('location-form');
  if (locForm) {
    locForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(locForm, @json(route('ajax.locations.store')), function (id, data) {
        setHiddenAndSummary('locationID', id, 'summary-loc', data.label || id);
        alert('Location guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }

  // 4) Taxon
  const taxForm = document.getElementById('taxon-form');
  if (taxForm) {
    taxForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(taxForm, @json(route('ajax.taxa.store')), function (id, data) {
        setHiddenAndSummary('taxonID', id, 'summary-tax', data.label || id);
        alert('Taxon guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }

  // 5) Identification
  const idForm = document.getElementById('identification-form');
  if (idForm) {
    idForm.addEventListener('submit', function (e) {
      e.preventDefault();
      postForm(idForm, @json(route('ajax.identifications.store')), function (id, data) {
        setHiddenAndSummary('identificationID', id, 'summary-id', data.label || id);
        alert('Identification guardado y asignado: '+id);
        showTabOccurrence();
      });
    });
  }
})();
</script>
@endpush

@push('scripts')
<script>
(function () {
  // ====== Claves de almacenamiento ======
  const KEY_OCC   = 'occ_wizard_occurrence_v2';
  const KEY_RL    = 'occ_wizard_record_level_v2';
  const KEY_ORG   = 'occ_wizard_organism_v2';
  const KEY_LOC   = 'occ_wizard_location_v2';
  const KEY_TAX   = 'occ_wizard_taxon_v2';
  const KEY_ID    = 'occ_wizard_identification_v2';
  const KEY_TAB   = 'occ_wizard_active_v2';
  const KEY_LINKS = 'occ_wizard_links_v2'; // { record_level: {id,label}, organism: {...}, ... }

  // ====== Utilidades ======
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  function debounce(fn, ms) {
    let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
  }

  function serializeForm(root) {
    const out = {};
    const fields = root.querySelectorAll('input[name], select[name], textarea[name]');
    fields.forEach(el => {
      if (el.disabled) return;
      if (el.type === 'file') return;
      const name = el.name;
      if (el.type === 'checkbox') {
        if (!out[name]) out[name] = [];
        if (el.checked) out[name].push(el.value || 'on');
      } else if (el.type === 'radio') {
        if (el.checked) out[name] = el.value;
      } else if (el.tagName === 'SELECT' && el.multiple) {
        out[name] = Array.from(el.selectedOptions).map(o => o.value);
      } else {
        out[name] = el.value;
      }
    });
    return out;
  }

  function restoreForm(root, data) {
    const fields = root.querySelectorAll('input[name], select[name], textarea[name]');
    fields.forEach(el => {
      const name = el.name;
      if (!(name in data)) return;
      if (el.type === 'checkbox') {
        const arr = Array.isArray(data[name]) ? data[name] : [data[name]];
        el.checked = arr.includes(el.value || 'on');
      } else if (el.type === 'radio') {
        el.checked = data[name] === el.value;
      } else if (el.tagName === 'SELECT' && el.multiple) {
        const arr = Array.isArray(data[name]) ? data[name] : [data[name]];
        Array.from(el.options).forEach(o => o.selected = arr.includes(o.value));
      } else {
        el.value = data[name] ?? '';
      }
      el.dispatchEvent(new Event('change', { bubbles: true }));
    });
  }

  function getJSON(key, fallback = {}) {
    try { return JSON.parse(localStorage.getItem(key) || '') ?? fallback; }
    catch { return fallback; }
  }
  function setJSON(key, value) { localStorage.setItem(key, JSON.stringify(value)); }

  // ====== Resumen + vínculos (hidden + spans) ======
  const SELECT_MAP = {
    record_level: { input: 'record_level_id', summary: 'summary-rl'  },
    organism:     { input: 'organismID',       summary: 'summary-org' },
    location:     { input: 'locationID',       summary: 'summary-loc' },
    taxon:        { input: 'taxonID',          summary: 'summary-tax' },
    identification:{input: 'identificationID', summary: 'summary-id'  },
  };

  function setLink(kind, id, label) {
    const cfg = SELECT_MAP[kind]; if (!cfg) return;
    // hidden
    const $in = document.getElementById(cfg.input);
    if ($in) $in.value = id || '';
    // resumen
    const $sum = document.getElementById(cfg.summary);
    if ($sum) $sum.textContent = label || id || '—';

    // Persistir selección
    const links = getJSON(KEY_LINKS, {});
    links[kind] = { id, label };
    setJSON(KEY_LINKS, links);

    // Reflejar también en el borrador del form Occurrence (para no perder al F5)
    const occDraft = getJSON(KEY_OCC, {});
    occDraft[cfg.input] = id;
    setJSON(KEY_OCC, occDraft);
  }

  function restoreLinks() {
    const links = getJSON(KEY_LINKS, {});
    for (const [kind, v] of Object.entries(links)) {
      if (v && typeof v === 'object') setLink(kind, v.id, v.label);
    }
  }

  // ====== Autosave genérico por formulario ======
  let dirty = false; // alerta al salir

  function registerAutosave(formSelector, storageKey) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    // Restaurar
    const draft = getJSON(storageKey, {});
    if (Object.keys(draft).length) restoreForm(form, draft);

    // Guardar
    const save = debounce(() => {
      const data = serializeForm(form);
      setJSON(storageKey, data);
      dirty = true;
    }, 250);
    form.addEventListener('input',  save);
    form.addEventListener('change', save);

    // Si el form envía (sea AJAX o clásico), limpiamos ese draft
    form.addEventListener('submit', () => {
      localStorage.removeItem(storageKey);
      dirty = false;
    });
  }

  // Registrar autosave para TODOS los tabs
  registerAutosave('#occ-form',        KEY_OCC);
  registerAutosave('#rl-form',         KEY_RL);
  registerAutosave('#organism-form',   KEY_ORG);
  registerAutosave('#location-form',   KEY_LOC);
  registerAutosave('#taxon-form',      KEY_TAX);
  registerAutosave('#identification-form', KEY_ID);

  // ====== Restaurar links (resumen e inputs ocultos) al cargar ======
  restoreLinks();

  // ====== Recordar tab activo ======
  document.querySelectorAll('[data-bs-toggle="tab"]').forEach(el => {
    el.addEventListener('shown.bs.tab', (e) => {
      const targetSel = e.target?.getAttribute('data-bs-target') || e.target?.getAttribute('href');
      if (targetSel) localStorage.setItem(KEY_TAB, targetSel);
    });
  });
  const savedTab = localStorage.getItem(KEY_TAB);
  if (savedTab) {
    const trigger = document.querySelector(`[data-bs-target="${savedTab}"], a[href="${savedTab}"]`);
    if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
  }

  // ====== Interceptar submit de subforms (AJAX) y fijar vínculos ======
  async function postForm(form, onOk) {
    const res = await fetch(form.action, {
      method: form.method || 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: new FormData(form),
    });
    if (!res.ok) {
      let msg = 'Error al guardar';
      try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
      alert(msg);
      return;
    }
    const data = await res.json(); // {id, label?}
    if (typeof onOk === 'function') onOk(data);
  }

  // Record level
  const rlForm = document.getElementById('rl-form');
  if (rlForm) rlForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(rlForm, ({id, label}) => {
      setLink('record_level', id, label || ('#'+id));
      alert('Record level guardado y asignado: '+id);
      // Volver al tab Occurrence
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Organism
  const orgForm = document.getElementById('organism-form');
  if (orgForm) orgForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(orgForm, ({id, label}) => {
      setLink('organism', id, label || id);
      alert('Organism guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Location
  const locForm = document.getElementById('location-form');
  if (locForm) locForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(locForm, ({id, label}) => {
      setLink('location', id, label || id);
      alert('Location guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Taxon
  const taxForm = document.getElementById('taxon-form');
  if (taxForm) taxForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(taxForm, ({id, label}) => {
      setLink('taxon', id, label || id);
      alert('Taxon guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // Identification
  const idForm = document.getElementById('identification-form');
  if (idForm) idForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(idForm, ({id, label}) => {
      setLink('identification', id, label || id);
      alert('Identification guardado y asignado: '+id);
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  });

  // ====== Aviso al salir si hay cambios ======
  window.addEventListener('beforeunload', function (e) {
    // Si existe cualquiera de los borradores o hicimos cambios
    const anyDraft =
      localStorage.getItem(KEY_OCC) ||
      localStorage.getItem(KEY_RL)  ||
      localStorage.getItem(KEY_ORG) ||
      localStorage.getItem(KEY_LOC) ||
      localStorage.getItem(KEY_TAX) ||
      localStorage.getItem(KEY_ID);
    if (dirty || anyDraft) {
      e.preventDefault();
      e.returnValue = '';
      return '';
    }
  });

})();
</script>
@endpush

