@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-9">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Data Matrix 5x5 Partisi Awal</h5>
                 <a href="{{route('generatematrix5x5')}}" class="mt-2">
                    <button type="button" class="btn button-tambah"><i class="bi bi-arrow-clockwise me-1"></i> Generate Matriks 5x5x</button>
                  </a>


                </div>
              <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

              <!-- Table with stripped rows -->
              <div style="overflow-x: auto;">
              <table class="table datatable table-responsive">
                <thead>
                  <tr>

                    <th>No</th>
                    <th>Matriks_5_1</th>
                    <th>Matriks_5_2</th>
                    <th>Matriks_5_3</th>
                    <th>Matriks_5_4</th>
                    <th>Matriks_5_5</th>
                    <th>Total</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($matrix5 as $matrix)
                    <td>{{$loop->iteration}}</td>
                    <td>{{$matrix->matriks_5_1}}</td>
                    <td>{{$matrix->matriks_5_2}}</td>
                    <td>{{$matrix->matriks_5_3}}</td>
                    <td>{{$matrix->matriks_5_4}}</td>
                    <td>{{$matrix->matriks_5_5}}</td>
                    <td>{{ $matrix->matriks_5_1 + $matrix->matriks_5_2 + $matrix->matriks_5_3 + $matrix->matriks_5_4 + $matrix->matriks_5_5}}</td>
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