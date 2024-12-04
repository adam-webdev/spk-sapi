@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-9">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Data Matrix 3x3 Partisi Awal</h5>
                 <a href="{{route('generatematrix3x3')}}" class="mt-2">
                    <button type="button" class="btn button-tambah"><i class="bi bi-arrow-clockwise me-1"></i> Generate Matriks 3x3</button>
                  </a>


                </div>
              <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

              <!-- Table with stripped rows -->
              <div style="overflow-x: auto;">
              <table class="table datatable table-responsive">
                <thead>
                  <tr>

                    <th>No</th>
                    <th>Matriks_3_1</th>
                    <th>Matriks_3_2</th>
                    <th>Matriks_3_3</th>
                    <th>Total</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($matrix3 as $matrix)
                    <td>{{$loop->iteration}}</td>
                    <td>{{$matrix->matriks_3_1}}</td>
                    <td>{{$matrix->matriks_3_2}}</td>
                    <td>{{$matrix->matriks_3_3}}</td>
                    <td>{{ $matrix->matriks_3_1 + $matrix->matriks_3_2 + $matrix->matriks_3_3 }}</td>
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