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

        {{--  RECORD LEVEL Hidden real + campo de solo lectura + botón modal --}}
        <input type="hidden" name="record_level_id" id="record_level_id"
              value="{{ old('record_level_id', $item->record_level_id ?? '') }}">

        <label class="label d-block">Record level</label>
        <div class="input-group">
          <input type="text" id="record_level_label" class="form-control"
                placeholder="Selecciona o crea un Record level"
                value="{{ isset($item->record_level_id) ? ('#'.$item->record_level_id.($item->recordLevel?->datasetName ? ' — '.$item->recordLevel->datasetName : '')) : '' }}"
                readonly>
          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-record-level">
            Elegir / Crear
          </button>&nbsp;
          {{-- Acciones sobre el registro seleccionado --}}
          <div id="rl-actions" class="mt-1" style="display:none">
            <a id="rl-view"  class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="rl-edit"  class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>
        </div>

        <small id="summary-rl" class="text-muted d-block mt-1">—</small>


        {{-- ORGANISM: hidden real + label lectura + botón modal + acciones --}}
        <input type="hidden" name="organismID" id="organismID"
              value="{{ old('organismID', $item->organismID ?? '') }}">

        <label class="label d-block">Organism</label>
        <div class="input-group align-items-center">
          <input type="text" id="organism_label" class="form-control"
                placeholder="Selecciona o crea un Organism"
                value="{{ isset($item->organismID) ? $item->organismID : '' }}"
                readonly>

          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-organism">
            Elegir / Crear
          </button>&nbsp;
          <div id="org-actions" class="mt-1" style="display:none">
            <a id="org-view" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="org-edit" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>
        </div>

        <small id="summary-org" class="text-muted d-block mt-1">—</small>


        {{-- LOCATION: hidden real + label lectura + botón modal + acciones --}}
        <input type="hidden" name="locationID" id="locationID"
              value="{{ old('locationID', $item->locationID ?? '') }}">

        <label class="label d-block">Location</label>
        <div class="input-group align-items-center">
          <input type="text" id="location_label" class="form-control"
                placeholder="Selecciona o crea una Location"
                value="{{ isset($item->locationID) ? $item->locationID : '' }}"
                readonly>

          <button type="button" class="btn btn-outline-primary"
                  data-bs-toggle="modal" data-bs-target="#modal-location">
            Elegir / Crear
          </button>&nbsp;
          <div id="loc-actions" class="mt-1" style="display:none">
            <a id="loc-view" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Ver</a>
            <a id="loc-edit" class="btn btn-link p-2" target="_blank" rel="noopener noreferrer">Editar</a>
          </div>

        </div>

        <small id="summary-loc" class="text-muted d-block mt-1">—</small>





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
          <div class="col-md-4">
            <label class="label" for="behavior">Behavior</label>
            <textarea name="behavior" id="behavior" rows="2" class="input">{{ old('behavior') }}</textarea>
            @error('behavior') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="substrate">Substrate</label>
            <textarea name="substrate" id="substrate" rows="2" class="input">{{ old('substrate') }}</textarea>
            @error('substrate') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="preparations">Preparations</label>
            <textarea name="preparations" id="preparations" rows="2" class="input">{{ old('preparations') }}</textarea>
            @error('preparations') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="associatedMedia">Associated media</label>
            <textarea name="associatedMedia" id="associatedMedia" rows="2" class="input">{{ old('associatedMedia') }}</textarea>
            @error('associatedMedia') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="associatedSequences">Associated sequences</label>
            <textarea name="associatedSequences" id="associatedSequences" rows="2" class="input">{{ old('associatedSequences') }}</textarea>
            @error('associatedSequences') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="associatedTaxa">Associated taxa</label>
            <textarea name="associatedTaxa" id="associatedTaxa" rows="2" class="input">{{ old('associatedTaxa') }}</textarea>
            @error('associatedTaxa') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="otherCatalogNumbers">Other catalog numbers</label>
            <textarea name="otherCatalogNumbers" id="otherCatalogNumbers" rows="2" class="input">{{ old('otherCatalogNumbers') }}</textarea>
            @error('otherCatalogNumbers') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          <div class="col-md-4">
            <label class="label" for="occurrenceRemarks">Occurrence remarks</label>
            <textarea name="occurrenceRemarks" id="occurrenceRemarks" rows="2" class="input">{{ old('occurrenceRemarks') }}</textarea>
            @error('occurrenceRemarks') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-success">Guardar Occurrence</button>
          <button type="button" id="btn-clear-all" class="btn btn-sm btn-outline-secondary">Limpiar borradores y vínculos</button>
        </div>

      </form>


       {{--------------- INICIO DEL PROCESO RECORD LEVEL ---------------------}}

        {{-- MODAL: Record Level --}}
        <div class="modal fade" id="modal-record-level" tabindex="-1" aria-hidden="true"> 
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Record level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                {{-- Buscar existentes --}}
                <div class="mb-3">
                  <input type="text" id="rl-search" class="form-control" placeholder="Buscar por ID o datasetName…">
                  <div id="rl-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Crear nuevo (AJAX) --}}
                <form id="rl-modal-form" action="{{ route('ajax.record-levels.store') }}" method="POST">
                  @csrf
                  @include('pages.record-level.partials.form', [
                    'item'                  => null,
                    'types'                 => $types,
                    'licenses'              => $licenses,
                    'rightsHolders'         => $rightsHolders,
                    'accessRights'          => $accessRights,
                    'institutionIds'        => $institutionIds,
                    'collectionIds'         => $collectionIds,
                    'institutionCodes'      => $institutionCodes,
                    'collectionCodes'       => $collectionCodes,
                    'ownerInstitutionCodes' => $ownerInstitutionCodes,
                    'basisOfRecords'        => $basisOfRecords,
                  ])
                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        @push('scripts')
        <script>
        (function () {
          const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

          // Plantillas de rutas para Ver/Editar (resource web)
          const rlShowTpl = @json(route('record-level.show', '__ID__'));
          const rlEditTpl = @json(route('record-level.edit', '__ID__'));

          // Toast helper
          function showToast(message, variant = 'success') {
            const area = document.getElementById('toast-area');
            if (!area || !window.bootstrap) { alert(message); return; }

            const el = document.createElement('div');
            el.className = `toast align-items-center text-bg-${variant} border-0`;
            el.setAttribute('role','alert');
            el.setAttribute('aria-live','assertive');
            el.setAttribute('aria-atomic','true');
            el.innerHTML = `
              <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`;
            area.appendChild(el);

            const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
          }

          // Cerrar modal (robusto)
          function closeModalById(id) {
            const el = document.getElementById(id);
            if (!el) { console.warn('Modal no encontrada:', id); return; }

            let inst = window.bootstrap?.Modal.getInstance(el);
            if (!inst) inst = window.bootstrap?.Modal.getOrCreateInstance(el);

            if (inst) {
              inst.hide();
            } else {
              el.classList.remove('show');
              el.style.display = 'none';
              document.body.classList.remove('modal-open');
              document.body.style.removeProperty('padding-right');
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }
          }

          // Enlaza/visibiliza los links Ver/Editar según el ID actual
          function updateRlLinks(id) {
            const $actions = document.getElementById('rl-actions');
            const $view    = document.getElementById('rl-view');
            const $edit    = document.getElementById('rl-edit');

            if (id && $actions && $view && $edit) {
              $view.href = rlShowTpl.replace('__ID__', encodeURIComponent(id));
              $edit.href = rlEditTpl.replace('__ID__', encodeURIComponent(id));
              $actions.style.display = 'flex';
            } else if ($actions) {
              $actions.style.display = 'none';
            }
          }

          // Aplica id/label en el form principal, actualiza links y cierra modal
          function applyRecordLevel(id, label) {
            document.getElementById('record_level_id').value = id;
            const $label = document.getElementById('record_level_label');
            if ($label) $label.value = label || ('#'+id);
            const $sum = document.getElementById('summary-rl');
            if ($sum) $sum.textContent = label || ('#'+id);

            updateRlLinks(id);
            closeModalById('modal-record-level');

            // Persistencia opcional (autosave wizard)
            try {
              const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
              draft['record_level_id'] = id;
              localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

              const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
              links['record_level'] = { id, label: label || ('#'+id) };
              localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
            } catch {}
          }

          // Submit AJAX del formulario dentro de la modal
          const rlForm = document.getElementById('rl-modal-form');
          if (!rlForm) return;

          const submitBtn = rlForm.querySelector('button[type="submit"]');

          rlForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const originalHTML = submitBtn?.innerHTML;
            submitBtn?.setAttribute('disabled', 'disabled');
            if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

            try {
              const res = await fetch(rlForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json'
                },
                body: new FormData(rlForm)
              });

              if (!res.ok) {
                let msg = 'Error al guardar';
                try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                showToast(msg, 'danger');
                return;
              }

              const data = await res.json(); // { id, label? }
              applyRecordLevel(data.id, data.label);
              showToast('Record level guardado y asignado ✅', 'success');

            } catch (err) {
              showToast('Error de red o servidor.', 'danger');
            } finally {
              if (submitBtn) {
                submitBtn.innerHTML = originalHTML || 'Guardar y usar';
                submitBtn.removeAttribute('disabled');
              }
            }
          });

          // Buscador de existentes en la modal
          const $q = document.getElementById('rl-search');
          const $results = document.getElementById('rl-results');
          function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

          if ($q && $results) {
            const doSearch = debounce(async () => {
              const q = $q.value.trim();
              if (q.length < 2) { $results.innerHTML = ''; return; }

              const url = @json(route('ajax.record-levels.search')) + '?q=' + encodeURIComponent(q);
              const res = await fetch(url, { headers:{ 'Accept':'application/json' }, credentials:'same-origin' });
              const items = res.ok ? await res.json() : [];

              $results.innerHTML = items.length
                ? items.map(i =>
                  `<button type="button" class="list-group-item list-group-item-action"
                          data-id="${i.id}" data-label="${i.text}">
                    ${i.text} 
                  </button>`).join('')
                : '<div class="list-group-item text-muted">Sin resultados</div>';
            }, 300);

            $q.addEventListener('input', doSearch);

            $results.addEventListener('click', (e) => {
              const btn = e.target.closest('.list-group-item');
              if (!btn) return;
              applyRecordLevel(btn.dataset.id, btn.dataset.label);
              showToast('Record level asignado ✅');
            });
          }

          // Estado inicial: si ya había uno seleccionado, mostrar acciones Ver/Editar
          document.addEventListener('DOMContentLoaded', () => {
            const current = document.getElementById('record_level_id')?.value;
            if (current) updateRlLinks(current);
          });
        })();
        </script>
        @endpush


        {{--------------- FIN DEL PROCESO ---------------------}}

        {{--------------- INICIO DEL PROCESO ORGANISM ---------------------}}

        <div class="modal fade" id="modal-organism" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Organism — Buscar / Crear</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body">
                {{-- Buscador --}}
                <div class="mb-3">
                  <label class="label">Buscar Organism</label>
                  <input type="text" id="org-search" class="form-control" placeholder="ID, occurrences, organisms, identifications...">
                  <div id="org-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Form de creación/edición rápida --}}
                <form id="org-modal-form" action="{{ route('ajax.organisms.store') }}" method="POST">
                  @csrf

                   @include('pages.organism.partials.form', [
                      'item' => null,
                      'idPrefix' => 'ml_'
                  ])

                  <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        @push('scripts')
          <script>
          (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // Rutas Ver/Editar
            const orgShowTpl = @json(route('organism.show', '__ID__'));
            const orgEditTpl = @json(route('organism.edit', '__ID__'));

            // Helpers
            function showToast(message, variant = 'success') {
              const area = document.getElementById('toast-area');
              if (!area || !window.bootstrap) { alert(message); return; }
              const el = document.createElement('div');
              el.className = `toast align-items-center text-bg-${variant} border-0`;
              el.setAttribute('role','alert');
              el.setAttribute('aria-live','assertive');
              el.setAttribute('aria-atomic','true');
              el.innerHTML = `
                <div class="d-flex">
                  <div class="toast-body">${message}</div>
                  <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>`;
              area.appendChild(el);
              const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
              t.show();
              el.addEventListener('hidden.bs.toast', () => el.remove());
            }

            function closeModalById(id) {
              const el = document.getElementById(id);
              if (!el) return;
              let inst = window.bootstrap?.Modal.getInstance(el) || window.bootstrap?.Modal.getOrCreateInstance(el);
              if (inst) inst.hide();
              else {
                el.classList.remove('show'); el.style.display = 'none';
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('padding-right');
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
              }
            }

            function updateOrgLinks(id) {
              const $actions = document.getElementById('org-actions');
              const $view    = document.getElementById('org-view');
              const $edit    = document.getElementById('org-edit');

              if (id && $actions && $view && $edit) {
                $view.href = orgShowTpl.replace('__ID__', encodeURIComponent(id));
                $edit.href = orgEditTpl.replace('__ID__', encodeURIComponent(id));
                $actions.style.display = 'flex';
              } else if ($actions) {
                $actions.style.display = 'none';
              }
            }

            function applyOrganism(id, label) {
              document.getElementById('organismID').value = id;
              const $label = document.getElementById('organism_label');
              if ($label) $label.value = label || id;
              const $sum = document.getElementById('summary-org');
              if ($sum) $sum.textContent = label || id;

              updateOrgLinks(id);
              closeModalById('modal-organism');
              showToast('Organism guardado/asignado ✅', 'success');

              // Persistencia opcional (si usas autosave del wizard)
              try {
                const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
                draft['organismID'] = id;
                localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

                const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
                links['organism'] = { id, label: label || id };
                localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
              } catch {}
            }

            // Submit AJAX del form en la modal
            const orgForm   = document.getElementById('org-modal-form');
            const submitBtn = orgForm?.querySelector('button[type="submit"]');

            orgForm?.addEventListener('submit', async function (e) {
              e.preventDefault();

              const originalHTML = submitBtn?.innerHTML;
              submitBtn?.setAttribute('disabled','disabled');
              if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

              try {
                const res = await fetch(orgForm.action, {
                  method: 'POST',
                  credentials: 'same-origin',
                  headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                  },
                  body: new FormData(orgForm)
                });

                if (!res.ok) {
                  let msg = 'Error al guardar';
                  try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                  showToast(msg, 'danger');
                  return;
                }

                const data = await res.json(); // { id, label }
                applyOrganism(data.id, data.label);

              } catch (err) {
                showToast('Error de red o servidor.', 'danger');
              } finally {
                if (submitBtn) {
                  submitBtn.innerHTML = originalHTML || 'Guardar y usar';
                  submitBtn.removeAttribute('disabled');
                }
              }
            });

            // Buscador en la modal
            const $q = document.getElementById('org-search');
            const $results = document.getElementById('org-results');

            function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

            if ($q && $results) {
              const doSearch = debounce(async () => {
                const q = $q.value.trim();
                if (q.length < 2) { $results.innerHTML = ''; return; }

                const url = @json(route('ajax.organisms.search')) + '?q=' + encodeURIComponent(q);
                const res = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials:'same-origin' });
                const items = res.ok ? await res.json() : [];

                $results.innerHTML = (items && items.length && items[0].id !== '')
                  ? items.map(i => `
                      <button type="button" class="list-group-item list-group-item-action"
                              data-id="${i.id}" data-label="${i.text}">
                        ${i.text}
                      </button>`).join('')
                  : '<div class="list-group-item text-muted">Sin resultados</div>';
              }, 300);

              $q.addEventListener('input', doSearch);

              $results.addEventListener('click', (e) => {
                const btn = e.target.closest('.list-group-item');
                if (!btn) return;
                applyOrganism(btn.dataset.id, btn.dataset.label);
                showToast('Organism asignado ✅');
              });
            }

            // Estado inicial: si ya existe organismID, mostrar acciones
            document.addEventListener('DOMContentLoaded', () => {
              const current = document.getElementById('organismID')?.value;
              if (current) updateOrgLinks(current);
            });
          })();
          </script>
        @endpush


        {{--------------- FIN DEL PROCESO ---------------------}}

        {{--------------- INICIO DEL PROCESO LOCATION ---------------------}}

        <div class="modal fade" id="modal-location" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Location — Buscar / Crear</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body">
                {{-- Buscador --}}
                <div class="mb-3">
                  <label class="label">Buscar Location</label>
                  <input type="text" id="loc-search" class="form-control" placeholder="ID, locality, country, state/province…">
                  <div id="loc-results" class="list-group mt-2"></div>
                </div>

                <hr class="my-3">

                {{-- Modal Location (sólo cambio el cuerpo del <form>) --}}
                <form id="loc-modal-form" action="{{ route('ajax.locations.store') }}" method="POST">
                  @csrf

                  {{-- Reutilizamos el partial con TODOS los campos.
                      - idPrefix solo afecta los "id" y "for" (NO los "name"), para evitar colisiones de IDs.
                      - $item = null porque es creación rápida en modal.
                  --}}
                  @include('pages.location.partials.form', [
                      'item' => null,
                      'idPrefix' => 'ml_'
                  ])

                  <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar y usar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        @push('scripts')
        <script>
        (function () {
          const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

          // Rutas Ver/Editar
          const locShowTpl = @json(route('location.show', '__ID__'));
          const locEditTpl = @json(route('location.edit', '__ID__'));

          // Helpers
          function showToast(message, variant = 'success') {
            const area = document.getElementById('toast-area');
            if (!area || !window.bootstrap) { alert(message); return; }
            const el = document.createElement('div');
            el.className = `toast align-items-center text-bg-${variant} border-0`;
            el.setAttribute('role','alert');
            el.setAttribute('aria-live','assertive');
            el.setAttribute('aria-atomic','true');
            el.innerHTML = `
              <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
              </div>`;
            area.appendChild(el);
            const t = new bootstrap.Toast(el, { delay: 2500, autohide: true });
            t.show();
            el.addEventListener('hidden.bs.toast', () => el.remove());
          }

          function closeModalById(id) {
            const el = document.getElementById(id);
            if (!el) return;
            let inst = window.bootstrap?.Modal.getInstance(el) || window.bootstrap?.Modal.getOrCreateInstance(el);
            if (inst) inst.hide();
            else {
              el.classList.remove('show'); el.style.display = 'none';
              document.body.classList.remove('modal-open');
              document.body.style.removeProperty('padding-right');
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }
          }

          function updateLocLinks(id) {
            const $actions = document.getElementById('loc-actions');
            const $view    = document.getElementById('loc-view');
            const $edit    = document.getElementById('loc-edit');

            if (id && $actions && $view && $edit) {
              $view.href = locShowTpl.replace('__ID__', encodeURIComponent(id));
              $edit.href = locEditTpl.replace('__ID__', encodeURIComponent(id));
              $actions.style.display = 'flex';
            } else if ($actions) {
              $actions.style.display = 'none';
            }
          }

          function applyLocation(id, label) {
            document.getElementById('locationID').value = id;
            const $label = document.getElementById('location_label');
            if ($label) $label.value = label || id;
            const $sum = document.getElementById('summary-loc');
            if ($sum) $sum.textContent = label || id;

            updateLocLinks(id);
            closeModalById('modal-location');
            showToast('Location guardada/asignada ✅', 'success');

            // Persistencia opcional (autosave wizard)
            try {
              const draft = JSON.parse(localStorage.getItem('occ_wizard_occurrence_v2') || '{}');
              draft['locationID'] = id;
              localStorage.setItem('occ_wizard_occurrence_v2', JSON.stringify(draft));

              const links = JSON.parse(localStorage.getItem('occ_wizard_links_v2') || '{}');
              links['location'] = { id, label: label || id };
              localStorage.setItem('occ_wizard_links_v2', JSON.stringify(links));
            } catch {}
          }

          // Submit AJAX del form en la modal
          const locForm   = document.getElementById('loc-modal-form');
          const submitBtn = locForm?.querySelector('button[type="submit"]');

          locForm?.addEventListener('submit', async function (e) {
            e.preventDefault();

            const originalHTML = submitBtn?.innerHTML;
            submitBtn?.setAttribute('disabled','disabled');
            if (submitBtn) submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Guardando...`;

            try {
              const res = await fetch(locForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                  'X-CSRF-TOKEN': csrf,
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json'
                },
                body: new FormData(locForm)
              });

              if (!res.ok) {
                let msg = 'Error al guardar';
                try { const j = await res.json(); if (j?.message) msg = j.message; } catch {}
                showToast(msg, 'danger');
                return;
              }

              const data = await res.json(); // { id, label }
              applyLocation(data.id, data.label);

            } catch (err) {
              showToast('Error de red o servidor.', 'danger');
            } finally {
              if (submitBtn) {
                submitBtn.innerHTML = originalHTML || 'Guardar y usar';
                submitBtn.removeAttribute('disabled');
              }
            }
          });

          // Buscador en la modal
          const $q = document.getElementById('loc-search');
          const $results = document.getElementById('loc-results');

          function debounce(fn, ms){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

          if ($q && $results) {
            const doSearch = debounce(async () => {
              const q = $q.value.trim();
              if (q.length < 2) { $results.innerHTML = ''; return; }

              const url = @json(route('ajax.locations.search')) + '?q=' + encodeURIComponent(q);
              const res = await fetch(url, { headers: { 'Accept': 'application/json' }, credentials:'same-origin' });
              const items = res.ok ? await res.json() : [];

              $results.innerHTML = (items && items.length && items[0].id !== '')
                ? items.map(i => `
                    <button type="button" class="list-group-item list-group-item-action"
                            data-id="${i.id}" data-label="${i.text}">
                      ${i.text}
                    </button>`).join('')
                : '<div class="list-group-item text-muted">Sin resultados</div>';
            }, 300);

            $q.addEventListener('input', doSearch);

            $results.addEventListener('click', (e) => {
              const btn = e.target.closest('.list-group-item');
              if (!btn) return;
              applyLocation(btn.dataset.id, btn.dataset.label);
              showToast('Location asignada ✅');
            });
          }

          // Estado inicial: si ya existe locationID, mostrar acciones
          document.addEventListener('DOMContentLoaded', () => {
            const current = document.getElementById('locationID')?.value;
            if (current) updateLocLinks(current);
          });
        })();
        </script>
        @endpush

      {{--------------- FIN DEL PROCESO ---------------------}}

      {{---------- INICIO DE SCRIPTS PARA POBLAR LOS COMBOS CON DATA DE LOCALSTORAGE -------}}  
      
      @push('scripts')
      <script>
      (function () {
        // Claves usadas para guardar borradores y “selecciones vinculadas”
        const DRAFT_KEY = 'occ_wizard_occurrence_v2';
        const LINKS_KEY = 'occ_wizard_links_v2';

        // Mapea cada “pieza” a sus IDs de input (hidden + visible label) y a claves en storage
        const FIELDS = [
          {
            kind: 'record_level',
            hiddenId: 'record_level_id',
            labelId:  'record_level_label',
            summaryId:'summary-rl',
            // Cómo se llama en draft (autosave) y en links (selección)
            draftKey: 'record_level_id',
            linkKey:  'record_level',
            makeFallbackLabel: id => '#'+id
          },
          {
            kind: 'organism',
            hiddenId: 'organismID',
            labelId:  'organism_label',
            summaryId:'summary-org',
            draftKey: 'organismID',
            linkKey:  'organism',
            makeFallbackLabel: id => id
          },
          {
            kind: 'location',
            hiddenId: 'locationID',
            labelId:  'location_label',
            summaryId:'summary-loc',
            draftKey: 'locationID',
            linkKey:  'location',
            makeFallbackLabel: id => id
          },
          // Si luego agregas Taxon / Identification:
          // { kind:'taxon', hiddenId:'taxonID', labelId:'taxon_label', summaryId:'summary-tax', draftKey:'taxonID', linkKey:'taxon', makeFallbackLabel:id=>id },
          // { kind:'identification', hiddenId:'identificationID', labelId:'identification_label', summaryId:'summary-id', draftKey:'identificationID', linkKey:'identification', makeFallbackLabel:id=>id },
        ];

        function getEl(id){ return document.getElementById(id); }
        function setVal(id, v){ const el=getEl(id); if(el) el.value=(v??''); }
        function setTxt(id, t){ const el=getEl(id); if(el) el.textContent=(t??'—'); }

        function rehydrate() {
          let draft={}, links={};
          try { draft = JSON.parse(localStorage.getItem(DRAFT_KEY) || '{}'); } catch {}
          try { links = JSON.parse(localStorage.getItem(LINKS_KEY) || '{}'); } catch {}

          FIELDS.forEach(cfg => {
            const hiddenEl = getEl(cfg.hiddenId);
            const labelEl  = getEl(cfg.labelId);

            // 1) Si ya hay valor en el input hidden, lo respetamos y fabricamos un label si falta
            let id = hiddenEl?.value?.trim() || '';

            // 2) Si no hay id en el input, intentamos desde links (tiene {id,label})
            if (!id && links[cfg.linkKey]?.id) {
              id = (links[cfg.linkKey].id || '').trim();
            }

            // 3) Si todavía no hay id, probamos en draft (autosave)
            if (!id && draft[cfg.draftKey]) {
              id = (''+draft[cfg.draftKey]).trim();
            }

            // Si conseguimos un ID, calculamos el label (links trae label; si no, fabricamos)
            if (id) {
              const storedLabel = (links[cfg.linkKey]?.label || '').trim();
              const label = storedLabel || cfg.makeFallbackLabel(id);

              setVal(cfg.hiddenId, id);
              setVal(cfg.labelId, label);
              setTxt(cfg.summaryId, label);
            } else {
              // No hay nada que mostrar
              setVal(cfg.hiddenId, '');
              setVal(cfg.labelId, '');
              setTxt(cfg.summaryId, '—');
            }
          });
        }

        // Ejecuta al cargar el DOM
        document.addEventListener('DOMContentLoaded', rehydrate);
        // Fallback por si el DOMContentLoaded se dispara antes de que tus inputs existan
        window.addEventListener('load', rehydrate);
      })();
      </script>
      @endpush


    {{---------- FIN DE SCRIPTS PARA POBLAR LOS COMBOS CON DATA DE LOCALSTORAGE -------}}    



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
        alert('Record level guardado y asignado 2: ' + id);
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
    /* form.addEventListener('submit', () => {
      localStorage.removeItem(storageKey);
      dirty = false;
    }); */
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
/*   const rlForm = document.getElementById('rl-form');
  if (rlForm) rlForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await postForm(rlForm, ({id, label}) => {
      setLink('record_level', id, label || ('#'+id));
      alert('Record level guardado y asignado 1: '+id);
      // Volver al tab Occurrence
      const trigger = document.querySelector('[data-bs-target="#tab-occurrence"], a[href="#tab-occurrence"]');
      if (trigger && window.bootstrap?.Tab) new bootstrap.Tab(trigger).show();
    });
  }); */

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

  document.getElementById('btn-clear-all')?.addEventListener('click', () => {
    [KEY_OCC,KEY_RL,KEY_ORG,KEY_LOC,KEY_TAX,KEY_ID,KEY_LINKS].forEach(k => localStorage.removeItem(k));
    ['record_level_id','organismID','locationID','taxonID','identificationID'].forEach(id => {
      const el = document.getElementById(id); if (el) el.value = '';
    });
    ['summary-rl','summary-org','summary-loc','summary-tax','summary-id'].forEach(id => {
      const el = document.getElementById(id); if (el) el.textContent = '—';
    });
    
    // Evita el beforeunload y recarga
    dirty = false;                     // <— importante
    window.location.reload();          // <— recarga la página
  });


})();

</script>
@endpush

