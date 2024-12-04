@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Dataset Sapi</h5>

                <a href="{{route('datasetsapi.load')}}" class="mt-2">
                    <button type="button" class="btn button-tambah"><i class="bi bi-arrow-clockwise me-1"></i> Load Dataset</button>
                  </a>
                </div>
              <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

              <!-- Table with stripped rows -->
              <div style="overflow-x: auto;">
              <table class="table datatable table-responsive">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>Sapi</th>
                    <th>x1</th>
                    <th>x2</th>
                    <th>x3</th>
                    <th>x4</th>
                    <th>x5</th>
                    <th>x6</th>
                    <th>x7</th>
                    <th>x8</th>
                    <th>x9</th>
                    <th>x10</th>
                    <th>x11</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($datasetsapi as $ds)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$ds->x_sapi_id}} - {{$ds->jenis_sapi}}</td>
                    <td>{{$ds->x1}}</td>
                    <td>{{$ds->x2 }}</td>
                    <td>{{$ds->x3}}</td>
                    <td>{{$ds->x4 }}</td>
                    <td>{{$ds->x5}}</td>
                    <td>{{$ds->x6}}</td>
                    <td>{{$ds->x7}}</td>
                    <td>{{$ds->x8 }}</td>
                    <td>{{$ds->x9}}</td>
                    <td>{{$ds->x10 }}</td>
                    <td>{{$ds->x11 }}</td>

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