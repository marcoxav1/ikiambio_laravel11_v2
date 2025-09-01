@php
  $item = $item ?? null;
@endphp

{{-- PK (string). Si lo dejas vacío en "crear", puedes generarlo en el backend con UUID si quieres. --}}
<div class="col-md-6">
  <label class="label" for="organismID">Organism ID</label>
  <input type="text" name="organismID" id="organismID" class="input"
         value="{{ old('organismID', $item->organismID ?? '') }}"
         placeholder="Dejar vacío para autogenerar (opcional)">
  @error('organismID') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="col-md-12">
  <label class="label" for="associatedOccurrences">Associated Occurrences</label>
  <textarea name="associatedOccurrences" id="associatedOccurrences" rows="2" class="input">{{ old('associatedOccurrences', $item->associatedOccurrences ?? '') }}</textarea>
  @error('associatedOccurrences') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="col-md-12">
  <label class="label" for="associatedOrganisms">Associated Organisms</label>
  <textarea name="associatedOrganisms" id="associatedOrganisms" rows="2" class="input">{{ old('associatedOrganisms', $item->associatedOrganisms ?? '') }}</textarea>
  @error('associatedOrganisms') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="col-md-12">
  <label class="label" for="previousIdentifications">Previous Identifications</label>
  <textarea name="previousIdentifications" id="previousIdentifications" rows="2" class="input">{{ old('previousIdentifications', $item->previousIdentifications ?? '') }}</textarea>
  @error('previousIdentifications') <small class="text-danger">{{ $message }}</small> @enderror
</div>
