@extends('layouts.layoutmaster')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Edit Data Sapi Testing</h5>

    <!-- Floating Labels Form -->
    <form class="row g-3" method="post" action="{{ route('sapi-testing.update', $sapi->id) }}">
      @csrf
      @method('PUT') <!-- Menambahkan method PUT untuk form update -->

      <div class="col-md-6">
        <div class="form-floating">
          <input name="jenis_sapi" type="text" class="form-control @error('jenis_sapi') is-invalid @enderror"" id="floatingName" placeholder="Masukan Jenis Sapi..." value="{{ $sapi->jenis_sapi }}">
          <label for="floatingName">Jenis Sapi</label>
           @error('jenis_sapi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-floating">
          <input name="umur" type="number" class="form-control @error('umur') is-invalid @enderror"" id="floatingUmur" placeholder="Umur Sapi" value="{{ $sapi->umur }}">
          <label for="floatingUmur">Umur Sapi (Bln)</label>
           @error('umur')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-floating mb-3">
          <select name="jenis_kelamin" class="form-select" id="floatingJK" aria-label="State">
            <option value="1" {{ $sapi->jenis_kelamin == 1 ? 'selected' : '' }}>Jantan</option>
            <option value="0" {{ $sapi->jenis_kelamin == 0 ? 'selected' : '' }}>Betina</option>
          </select>
          <label for="floatingJK">Jenis Kelamin</label>

        </div>
      </div>
      <div class="col-md-6">
        <div class="form-floating">
          <input name="berat" type="number" class="form-control @error('berat') is-invalid @enderror"" id="floatingBerat" placeholder="Berat Sapi" value="{{ $sapi->berat }}">
          <label for="floatingBerat">Berat Sapi (kg)</label>
           @error('berat')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kondisi_mulut_datar" class="form-select" id="floatingMulut" aria-label="State">
            <option value="1" {{ $sapi->kondisi_mulut_datar == 1 ? 'selected' : '' }}>Datar</option>
            <option value="0" {{ $sapi->kondisi_mulut_datar == 0 ? 'selected' : '' }}>Papak</option>
          </select>
          <label for="floatingMulut">Kondisi Mulut Datar/Papak</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kepala" class="form-select" id="floatingKepala" aria-label="State">
            <option value="1" {{ $sapi->kepala == 1 ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ $sapi->kepala == 0 ? 'selected' : '' }}>Tidak</option>
          </select>
          <label for="floatingKepala">Kepala sesuai dengan BB/Tidak</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="leher_bergelambir" class="form-select" id="floatingLeher" aria-label="State">
            <option value="1" {{ $sapi->leher_bergelambir == 1 ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ $sapi->leher_bergelambir == 0 ? 'selected' : '' }}>Tidak</option>
          </select>
          <label for="floatingLeher">Leher Bergelambir/Tidak</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="punggung_datar" class="form-select" id="floatingPunggung" aria-label="State">
            <option value="1" {{ $sapi->punggung_datar == 1 ? 'selected' : '' }}>Datar</option>
            <option value="0" {{ $sapi->punggung_datar == 0 ? 'selected' : '' }}>Melengkung</option>
          </select>
          <label for="floatingPunggung">Punggung Datar/Melengkung</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="ekor_tidak_ada_legokan" class="form-select" id="floatingEkor" aria-label="State">
            <option value="1" {{ $sapi->ekor_tidak_ada_legokan == 1 ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ $sapi->ekor_tidak_ada_legokan == 0 ? 'selected' : '' }}>Tidak</option>
          </select>
          <label for="floatingEkor">Ekor Tidak Ada Legokan/Tidak</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kaki_tegak_besar" class="form-select" id="floatingKaki" aria-label="State">
            <option value="1" {{ $sapi->kaki_tegak_besar == 1 ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ $sapi->kaki_tegak_besar == 0 ? 'selected' : '' }}>Tidak</option>
          </select>
          <label for="floatingKaki">Kaki Tegak Besar/Tidak</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kondisi_gigi_lengkap" class="form-select" id="floatingGigi" aria-label="State">
            <option value="1" {{ $sapi->kondisi_gigi_lengkap == 1 ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ $sapi->kondisi_gigi_lengkap == 0 ? 'selected' : '' }}>Tidak</option>
          </select>
          <label for="floatingGigi">Gigi Lengkap/Tidak</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kondisi_mata_normal" class="form-select" id="floatingMata" aria-label="State">
            <option value="1" {{ $sapi->kondisi_mata_normal == 1 ? 'selected' : '' }}>Normal</option>
            <option value="0" {{ $sapi->kondisi_mata_normal == 0 ? 'selected' : '' }}>Menurun</option>
          </select>
          <label for="floatingMata">Mata Normal/Menurun</label>
        </div>
      </div>

      <div class="text-center col-md-12">
        <button type="submit" class="btn button-tambah w-100">Update</button>
        <a href="{{ route('sapi.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
      </div>
    </form><!-- End floating Labels Form -->

  </div>
</div>

@endsection
