@extends('layouts.layoutmaster')

@section('content')
 <div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Data Sapi</h5>

    <!-- Floating Labels Form -->
    <form class="row g-3" method="post" action="{{route('sapi.store')}}">
      @csrf
      <div class="col-md-6">
        <div class="form-floating">
          <input name="jenis_sapi" type="text" class="form-control @error('jenis_sapi') is-invalid @enderror" id="floatingName" placeholder="Masukan Jenis Sapi...">
          <label for="floatingName">Jenis Sapi</label>
           @error('jenis_sapi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-floating">
          <input name="umur" type="number" class="form-control @error('umur') is-invalid @enderror" id="floatingUmur" placeholder="Umur Sapi">
          <label for="floatingUmur">Umur Sapi (Bln)</label>
            @error('umur')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
     <div class="col-md-6">
        <div class="form-floating mb-3">
          <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" id="floatingJK" aria-label="State">
            <option value="jantan">Jantan</option>
            <option value="betina">Betina</option>
          </select>
          <label for="floatingJK">Jenis Kelamin</label>
            @error('jenis_kelamin')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
       <div class="col-md-6">
        <div class="form-floating">
          <input name="berat" type="number" class="form-control @error('berat') is-invalid @enderror" id="floatingBerat" placeholder="Berat Sapi">
          <label for="floatingBerat">Berat Sapi (kg)</label>
            @error('berat')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kondisi_mulut_datar" class="form-select @error('kondisi_mulut_datar') is-invalid @enderror" id="floatingMulut" aria-label="State">
            <option value="datar">Datar</option>
            <option value="papak">Papak</option>
          </select>
          <label for="floatingMulut">Kondisi Mulut Datar/Papak</label>
            @error('kondisi_mulut_datar')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kepala" class="form-select @error('kepala') is-invalid @enderror" id="floatingKepala" aria-label="State">
            <option value="ya">Ya</option>
            <option value="tidak">Tidak</option>
          </select>
          <label for="floatingKepala">Kepala sesuai dengan BB/Tidak</label>
            @error('kepala')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="leher_bergelambir" class="form-select @error('leher_bergelambir') is-invalid @enderror" id="floatingLeher" aria-label="State">
            <option value="ya">Ya</option>
            <option value="tidak">Tidak</option>
          </select>
          <label for="floatingLeher">Leher Bergelambir/Tidak</label>
            @error('leher_bergelambir')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="punggung_datar" class="form-select @error('punggung_datar') is-invalid @enderror" id="floatingPunggung" aria-label="State">
            <option value="datar">Datar</option>
            <option value="melengkung">Melengkung</option>
          </select>
          <label for="floatingPunggung">Punggung Datar/Melengkung</label>
            @error('punggung_datar')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="ekor_tidak_ada_legokan" class="form-select @error('ekor_tidak_ada_legokan') is-invalid @enderror" id="floatingEkor" aria-label="State">
            <option value="ya">Ya</option>
            <option value="tidak">Tidak</option>
          </select>
          <label for="floatingEkor">Ekor Tidak Ada Legokan/Tidak</label>
            @error('ekor_tidak_ada_legokan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kaki_tegak_besar" class="form-select @error('kaki_tegak_besar') is-invalid @enderror" id="floatingKaki" aria-label="State">
            <option value="ya">Ya</option>
            <option value="tidak">Tidak</option>
          </select>
          <label for="floatingKaki">Kaki Tegak Besar/Tidak</label>
            @error('kaki_tegak_besar')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kondisi_gigi_lengkap" class="form-select @error('kondisi_gigi_lengkap') is-invalid @enderror" id="floatingGigi" aria-label="State">
            <option value="ya">Ya</option>
            <option value="tidak">Tidak</option>
          </select>
          <label for="floatingGigi">Gigi Lengkap/Tidak</label>
            @error('kondisi_gigi_lengkap')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating mb-3">
          <select name="kondisi_mata_normal" class="form-select @error('kondisi_mata_normal') is-invalid @enderror" id="floatingMata" aria-label="State">
            <option value="normal">Normal</option>
            <option value="menurun">Menurun</option>
          </select>
          <label for="floatingMata">Mata Normal/Menurun</label>
            @error('kondisi_mata_normal')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="text-center col-md-12">
        <button type="submit" class="btn button-tambah w-100  ">Simpan</button>
        <button type="button" class="btn btn-secondary w-100  mt-2" onclick="window.history.back(-1);"

        >Kembali</button>
      </div>
    </form><!-- End floating Labels Form -->

  </div>
</div>

@endsection