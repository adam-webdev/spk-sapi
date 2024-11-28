@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Fuzzy Tahani</h5>

              </div>
                <hr >
              <form class="row g-3 mt-3" method="post" action="{{route('ftahani.process')}}">
                @csrf
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-floating">
                       <select name="jenis_sapi" class="form-select @error('jenis_sapi') is-invalid @enderror" id="floatingjenis" aria-label="State">
                        <option value="">-- Pilih salah satu --</option>
                        @foreach($sapi as $i => $value)
                        <option value="{{$sapi[$i]->jenis_sapi}}">{{$sapi[$i]->jenis_sapi}}</option>
                        @endforeach
                      </select>
                      <label for="floatingjenis">Pilih jenis sapi</label>
                        @error('jenis_sapi')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                     <select name="umur" class="form-select @error('umur') is-invalid @enderror" id="floatingumur" aria-label="State">
                        <option value="">-- Pilih salah satu --</option>
                        <option value="muda">Muda</option>
                        <option value="dewasa">Dewasa</option>
                        <option value="tua">Tua</option>
                      </select>
                      <label for="floatingumur">Pilih Umur</label>
                    </div>
                  </div>
                </div>
                <div class="form-group row mt-4">
                  <div class="col-md-6">
                    <div class="form-floating">
                     <select name="berat" class="form-select @error('berat') is-invalid @enderror" id="floatingberat" aria-label="State">
                        <option value="">-- Pilih salah satu --</option>
                        <option value="ringan">Ringan</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                      </select>
                      <label for="floatingberat">Pilih Berat</label>
                    </div>
                  </div>
                </div>

                <div class="text-center col-md-12">
                  <button type="submit" class="btn button-tambah w-100  ">Cari Data </button>
                  <button type="button" class="btn btn-secondary w-100  mt-2" onclick="window.history.back(-1);"

                  >Kembali</button>
                </div>
              </form>
              <!-- End floating Labels Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection