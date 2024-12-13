@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Fuzzy C-Means</h5>

              </div>
                <hr >
              <form class="row g-3 mt-3" method="post" action="{{route('fuzzy-c-means.process')}}">
                @csrf
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-floating">
                       <select name="cluster" class="form-select @error('cluster') is-invalid @enderror" id="floatingcluster" aria-label="State">
                        <option value="">-- Pilih salah satu --</option>
                        <option value="2">2</option>
                        <!-- <option value="3">3</option>
                        <option value="4">4</option> -->
                      </select>
                      <label for="floatingcluster">Pilih Jumlah Cluster</label>
                        @error('cluster')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                     <select name="epsilon" class="form-select @error('epsilon') is-invalid @enderror" id="floatingepsilon" aria-label="State">
                        <option value="">-- Pilih salah satu --</option>
                        <option value="0.000001">0.000001</option>
                        <option value="0.00001">0.00001</option>
                        <option value="0.0001">0.0001</option>
                        <option value="0.001">0.001</option>
                        <option value="0.01">0.01</option>
                      </select>
                      <label for="floatingepsilon">Pilih Epsilon</label>
                    </div>
                  </div>
                </div>
                <div class="form-group row mt-4">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input name="max_iter" min="10" type="number" class="form-control @error('max_iter') is-invalid @enderror" id="floatingIter" placeholder="100">
                      <label for="floatingIter">Max iterasi </label>
                      @error('max_iter')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="text-center col-md-12">
                  <button type="submit" class="btn button-tambah w-100  ">Proses Hitung FCM</button>
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