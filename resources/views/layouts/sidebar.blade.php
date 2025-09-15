<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Inicio — IKIAM')</title>
  @vite(['resources/css/custom.css','resources/js/app.js'])
</head>
<body class="app">
  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="brand brand--clickable" onclick="location.href='{{ route('home') }}'"> 
      @include('svg.salamander') <span>IKIAMBIA</span>
    </div>

    <nav class="menu">

      <a class="item {{ request()->routeIs('location.*') ? 'active' : '' }}" href="{{ route('location.index') }}">
        @include('svg.users')
        <span>LOCATION</span>
      </a>
      <a class="item {{ request()->routeIs('organism.*') ? 'active' : '' }}" href="{{ route('organism.index') }}">
        @include('svg.cap')
        <span>ORGANISM</span>
      </a>
      <a class="item {{ request()->routeIs('taxon.*') ? 'active' : '' }}" href="{{ route('taxon.index') }}">
        @include('svg.list')
        <span>TAXON</span>
      </a>
      <a class="item {{ request()->routeIs('record-level.*') ? 'active' : '' }}" href="{{ route('record-level.index') }}">
        @include('svg.shield')
        <span>RECORD LEVEL</span>
      </a>
       <a class="item {{ request()->routeIs('identification.*') ? 'active' : '' }}" href="{{ route('identification.index') }}">
        @include('svg.role')
        <span>IDENTIFICATION</span>
      </a>
      <a class="item {{ request()->routeIs('occurrence.*') ? 'active' : '' }}" href="{{ route('occurrence.index') }}">
          @include('svg.users')
          <span>OCCURRENCE</span>
      </a>      
     
      @php
        $vocabsOpen =
            request()->routeIs('vocab-record-level-*')
         || request()->routeIs('vocab-occurrence-*')
         || request()->routeIs('vocab-location-*')
         || request()->routeIs('vocab-taxon-*')
         || request()->routeIs('vocab-identification-*')
         || request()->routeIs('vocab-tblprimers-*')
         || request()->routeIs('tblprimersf.*')
         || request()->routeIs('tblprimersr.*');
      @endphp

      {{-- ==================== REGISTRO VOCABS (PADRE) ==================== --}}
      <div class="group collapsible {{ $vocabsOpen ? 'open' : '' }}" data-key="vocabs">

        <button class="item group-header" type="button">
        @include('svg.list')
        <span>FUNCIONALIDADES</span>
      </button>

        <div class="group-items">

          {{-- ==================== RECORD LEVEL ==================== --}}
          <div class="group collapsible {{ request()->routeIs('vocab-record-level-*') ? 'open' : '' }}" data-key="record-level">
            <button class="group-header" type="button">
              <span>RECORD LEVEL</span>
              <span class="chev" aria-hidden="true"></span>
            </button>
            <div class="group-items">
              <a class="item {{ request()->routeIs('vocab-record-level-type.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-type.index') }}">
                @include('svg.check') <span>Registrar tipos</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-license.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-license.index') }}">
                @include('svg.check') <span>Registrar licenses</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-rights-holder.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-rights-holder.index') }}">
                @include('svg.check') <span>Registrar rightsHolder</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-access-rights.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-access-rights.index') }}">
                @include('svg.check') <span>Registrar accessRights</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-institution-id.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-institution-id.index') }}">
                @include('svg.check') <span>Registrar institutionID</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-collection-id.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-collection-id.index') }}">
                @include('svg.check') <span>CollectionID</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-institution-code.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-institution-code.index') }}">
                @include('svg.check') <span>InstitutionCode</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-collection-code.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-collection-code.index') }}">
                @include('svg.check') <span>CollectionCode</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-owner-institution-code.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-owner-institution-code.index') }}">
                @include('svg.check') <span>OwnerInstitutionCode</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-record-level-basis-of-record.*') ? 'active' : '' }}" href="{{ route('vocab-record-level-basis-of-record.index') }}">
                @include('svg.check') <span>BasisOfRecord</span>
              </a>
            </div>
          </div>

          {{-- ====================== OCCURRENCE ===================== --}}
          <div class="group collapsible {{ request()->routeIs('vocab-occurrence-*') ? 'open' : '' }}" data-key="occurrence">
            <button class="group-header" type="button">
              <span>OCCURRENCE</span>
              <span class="chev" aria-hidden="true"></span>
            </button>
            <div class="group-items">
              <a class="item {{ request()->routeIs('vocab-occurrence-organism-quantity-type.*') ? 'active' : '' }}" href="{{ route('vocab-occurrence-organism-quantity-type.index') }}">
                @include('svg.check') <span>organismQuantityType</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-occurrence-sex.*') ? 'active' : '' }}" href="{{ route('vocab-occurrence-sex.index') }}">
                @include('svg.check') <span>Sex</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-occurrence-life-stage.*') ? 'active' : '' }}" href="{{ route('vocab-occurrence-life-stage.index') }}">
                @include('svg.check') <span>LifeStage</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-occurrence-reproductive-condition.*') ? 'active' : '' }}" href="{{ route('vocab-occurrence-reproductive-condition.index') }}">
                @include('svg.check') <span>ReproductiveCondition</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-occurrence-establishment-means.*') ? 'active' : '' }}" href="{{ route('vocab-occurrence-establishment-means.index') }}">
                @include('svg.check') <span>EstablishmentMeans</span>
              </a>
              <a class="item {{ request()->routeIs('vocab-occurrence-disposition.*') ? 'active' : '' }}" href="{{ route('vocab-occurrence-disposition.index') }}">
                @include('svg.check') <span>Disposition</span>
              </a>

              @if (Route::has('measurement-or-facts.index'))
                <a class="item {{ request()->routeIs('measurement-or-facts.*') ? 'active' : '' }}"
                  href="{{ route('measurement-or-facts.index') }}">
                  @include('svg.check') <span>Measurement / Facts</span>
                </a>
              @endif
              @if (Route::has('tbl-multimedia.index'))
                <a class="item {{ request()->routeIs('tbl-multimedia.*') ? 'active' : '' }}"
                  href="{{ route('tbl-multimedia.index') }}">
                  @include('svg.check') <span>Multimedia</span>
                </a>
              @endif
              @if (Route::has('tbl-extractions.index'))
                <a class="item {{ request()->routeIs('tbl-extractions.*') ? 'active' : '' }}"
                  href="{{ route('tbl-extractions.index') }}">
                  @include('svg.check') <span>Extracciones</span>
                </a>
              @endif

            </div>
          </div>

          {{-- ======================= LOCATION ====================== --}}
          <div class="group collapsible {{ request()->routeIs('vocab-location-*') ? 'open' : '' }}" data-key="location">
            <button class="group-header" type="button">
              <span>LOCATION</span>
              <span class="chev" aria-hidden="true"></span>
            </button>
            <div class="group-items">
              @if (Route::has('vocab-location-continent.index'))
              <a class="item {{ request()->routeIs('vocab-location-continent.*') ? 'active' : '' }}" href="{{ route('vocab-location-continent.index') }}">
                @include('svg.check') <span>Continent</span>
              </a>
              @endif

              @if (Route::has('vocab-location-verbatim-srs.index'))
              <a class="item {{ request()->routeIs('vocab-location-verbatim-srs.*') ? 'active' : '' }}" href="{{ route('vocab-location-verbatim-srs.index') }}">
                @include('svg.check') <span>Verbatim SRS</span>
              </a>
              @endif

              @if (Route::has('vocab-location-georef-status.index'))
              <a class="item {{ request()->routeIs('vocab-location-georef-status.*') ? 'active' : '' }}" href="{{ route('vocab-location-georef-status.index') }}">
                @include('svg.check') <span>Georef status</span>
              </a>
              @endif
            </div>
          </div>

          {{-- ======================== TAXON ======================== --}}
          <div class="group collapsible {{ request()->routeIs('vocab-taxon-*') ? 'open' : '' }}" data-key="taxon">
            <button class="group-header" type="button">
              <span>TAXON</span>
              <span class="chev" aria-hidden="true"></span>
            </button>
            <div class="group-items">
              @if (Route::has('vocab-taxon-taxon-rank.index'))
              <a class="item {{ request()->routeIs('vocab-taxon-taxon-rank.*') ? 'active' : '' }}" href="{{ route('vocab-taxon-taxon-rank.index') }}">
                @include('svg.check') <span>Taxon rank</span>
              </a>
              @endif

              @if (Route::has('vocab-taxon-taxonomic-status.index'))
              <a class="item {{ request()->routeIs('vocab-taxon-taxonomic-status.*') ? 'active' : '' }}" href="{{ route('vocab-taxon-taxonomic-status.index') }}">
                @include('svg.check') <span>Taxonomic status</span>
              </a>
              @endif
            </div>
          </div>

          {{-- ==================== IDENTIFICATION =================== --}}
          <div class="group collapsible {{ request()->routeIs('vocab-identification-*') ? 'open' : '' }}" data-key="identification">
            <button class="group-header" type="button">
              <span>IDENTIFICATION</span>
              <span class="chev" aria-hidden="true"></span>
            </button>
            <div class="group-items">
              @if (Route::has('vocab-identification-type-status.index'))
              <a class="item {{ request()->routeIs('vocab-identification-type-status.*') ? 'active' : '' }}" href="{{ route('vocab-identification-type-status.index') }}">
                @include('svg.check') <span>Type status</span>
              </a>
              @endif

              @if (Route::has('vocab-identification-verification-status.index'))
              <a class="item {{ request()->routeIs('vocab-identification-verification-status.*') ? 'active' : '' }}" href="{{ route('vocab-identification-verification-status.index') }}">
                @include('svg.check') <span>Verification status</span>
              </a>
              @endif
            </div>
          </div>

          {{-- ====================== TBLPRIMERS ===================== --}}
          <div class="group collapsible {{ (request()->routeIs('vocab-tblprimers-*') || request()->routeIs('tblprimersf.*') || request()->routeIs('tblprimersr.*')) ? 'open' : '' }}" data-key="tblprimers">
            <button class="group-header" type="button">
              <span>TBLPRIMERS</span>
              <span class="chev" aria-hidden="true"></span>
            </button>
            <div class="group-items">
              @if (Route::has('vocab-tblprimers-primer-direction.index'))
              <a class="item {{ request()->routeIs('vocab-tblprimers-primer-direction.*') ? 'active' : '' }}" href="{{ route('vocab-tblprimers-primer-direction.index') }}">
                @include('svg.check') <span>Primer direction</span>
              </a>
              @endif

              @if (Route::has('tblprimersf.index'))
              <a class="item {{ request()->routeIs('tblprimersf.*') ? 'active' : '' }}" href="{{ route('tblprimersf.index') }}">
                @include('svg.check') <span>Primers F</span>
              </a>
              @endif

              @if (Route::has('tblprimersr.index'))
              <a class="item {{ request()->routeIs('tblprimersr.*') ? 'active' : '' }}" href="{{ route('tblprimersr.index') }}">
                @include('svg.check') <span>Primers R</span>
              </a>
              @endif
            </div>
          </div>
          
        </div>
      </div>

      <a class="item {{ request()->routeIs('ikiambio-users.*') ? 'active' : '' }}" href="{{ route('ikiambio-users.index') }}">
        @include('svg.users')
        <span>Usuarios</span>
      </a>

       <a class="item {{ request()->routeIs('ikiambio-users.*') ? 'active' : '' }}" href="{{ route('ikiambio-users.index') }}">
        @include('svg.admins')
        <span>Usuarios administradores</span>
      </a>
    </nav>
  </aside>

  {{-- Contenido --}}
  <section class="content">
    <header class="topbar">
      <div class="topbar-title">@yield('page_title','Inicio')</div>
      <div class="topbar-user">
        @include('svg.user')
        <span>Admin MS2S</span>
      </div>
    </header>

    <main class="content-body">
      @yield('content')
    </main>
  </section>
  @stack('scripts')
</body>
</html>
