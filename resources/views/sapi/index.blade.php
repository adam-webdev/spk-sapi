@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Data Sapi</h5>
                <div class="mt-3">
                  <a href="{{route('sapi.importForm')}}"  style="background: rgb(33, 222, 222)" class="btn text-white" >
                   <i class="fas fa-file-excel"></i>Import Excel
                    </a>

                  <a href="{{ route('sapi.excel') }}" class="btn text-white" style="background: rgb(53, 162, 162)"><i
                          class="fas fa-table"></i>Export
                      Excel</a>
                  <a href="{{ route('sapi.csv') }}" class="btn text-white" style="background: rgb(15, 136, 136)"><i
                          class="fas fa-file-csv"></i></i>Export
                      CSV</a>
                  <a href="{{route('sapi.create')}}" class="mt-2">
                    <button type="button" class="btn button-tambah"><i class="bi bi-plus me-1"></i> Tambah</button>
                  </a>
                </div>
                </div>
              <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

              <!-- Table with stripped rows -->
              <div style="overflow-x: auto;">
              <table class="table datatable table-responsive">
                <thead>
                  <tr>
                    <th>
                      Aksi
                    </th>
                    <th>
                      No
                    </th>
                    <th>Sapi</th>
                    <th>Umur</th>
                    <th>JK</th>
                    <th>Bobot</th>
                    <th>Mulut</th>
                    <th>Kepala</th>
                    <th>Leher</th>
                    <th>Punggung</th>
                    <th>Ekor</th>
                    <th>Kaki</th>
                    <th>Gigi</th>
                    <th>Mata</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sapi as $sapi)
                  <tr>
                    <td>
                      <div class="d-flex justify-content-between">
                        <a href="{{ route('sapi.edit', $sapi->id) }}" class="btn btn-secondary btn-sm me-2">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('sapi.destroy', $sapi->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin ingin menghapus data ini ?');">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                      </div>
                    </td>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$sapi->jenis_sapi}}</td>
                    <td>{{$sapi->umur}}</td>
                    <td>{{$sapi->jenis_kelamin }}</td>
                    <td>{{$sapi->berat}}</td>
                    <td>{{$sapi->kondisi_mulut_datar }}</td>
                    <td>{{$sapi->kepala}}</td>
                    <td>{{$sapi->leher_bergelambir}}</td>
                    <td>{{$sapi->punggung_datar}}</td>
                    <td>{{$sapi->ekor_tidak_ada_legokan }}</td>
                    <td>{{$sapi->kaki_tegak_besar}}</td>
                    <td>{{$sapi->kondisi_gigi_lengkap }}</td>
                    <td>{{$sapi->kondisi_mata_normal }}</td>

                  </tr>
                  @endforeach


                </tbody>
              </table>
              </div>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection