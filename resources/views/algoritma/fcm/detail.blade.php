@extends('layouts.layoutmaster')
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h6 class="mt-4 text-bold"><b>Perhitungan</b></h6>
                        <hr>
                        <table>
                            <tr>
                                <td>Jumlah Cluster</td>
                                <td> : </td>
                                <td> {{$hasilfcm->hasil_jumlah_cluster}}</td>
                            </tr>
                            <tr>
                                <td>Maksimum Iterasi</td>
                                <td> : </td>
                                <td> {{$hasilfcm->hasil_iterasi}}</td>
                            </tr>
                            <tr>
                                <td>Error Terkecil</td>
                                <td> : </td>
                                <td>{{number_format(abs($hasilfcm->hasil_error_terkecil), 6, '.', '')}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h6 class="mt-4"><b>Hasil Cluster Sapi Berkualitas</b></h6>
                        <hr>
                       <div style="overflow-x: auto;">
                        <table class="table mt-2 sapi table-striped table-bordered ">
                            <thead>
                            <tr>
                                <th>Kode</th>
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
                                <th>Cluster</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $hasilCluster = json_decode($hasilfcm->hasil_cluster)
                            @endphp
                            @foreach($hasilCluster as $key=>$value)
                                <tr>
                                    <td>C{{str_pad($loop->iteration, 4, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$datasetsapi[$key]->jenis_sapi}}</td>
                                    <td>{{$datasetsapi[$key]->umur}}</td>
                                    <td>{{$datasetsapi[$key]->jenis_kelamin}}</td>
                                    <td>{{$datasetsapi[$key]->berat}}</td>
                                    <td>{{$datasetsapi[$key]->kondisi_mulut_datar}}</td>
                                    <td>{{$datasetsapi[$key]->kepala}}</td>
                                    <td>{{$datasetsapi[$key]->leher_bergelambir}}</td>
                                    <td>{{$datasetsapi[$key]->punggung_datar}}</td>
                                    <td>{{$datasetsapi[$key]->ekor_tidak_ada_legokan}}</td>
                                    <td>{{$datasetsapi[$key]->kaki_tegak_besar}}</td>
                                    <td>{{$datasetsapi[$key]->kondisi_gigi_lengkap}}</td>
                                    <td>{{$datasetsapi[$key]->kondisi_mata_normal}}</td>
                                    <td>{{$value}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                 <th>Kode</th>
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
                                <th>Cluster</th>
                            </tr>
                            </tfoot>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card ">
                <div class="card-content">
                    <div class="card-body">
                        <h6 class="mt-4"><b>Hasil Pengelompokan Cluster</b></h6>
                        <hr>
                        <table class="table cluster table-striped table-bordered ">
                            <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Hasil Cluster</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $hasilCluster = json_decode($hasilfcm->hasil_cluster)
                            @endphp
                            @foreach($hasilCluster as $key=>$value)
                                <tr>
                                    <td>C{{str_pad($loop->iteration, 4, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$value}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Kode</th>
                                <th>Hasil Cluster</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h6 class="mt-4"><b>Fungsi Objektif dan Nilai Error</b></h6>
                        <hr>
                        <table class="table fo table-striped table-bordered ">
                            <thead>
                            <tr>
                                <th>Iterasi</th>
                                <th>Fungsi Objektif</th>
                                <th>Error</th>
                            </tr>
                            </thead>
                            @php
                                $hasilFungsiObjektif = json_decode($hasilfcm->fungsi_objektif);
                                $hasilError = json_decode($hasilfcm->error);
                            @endphp
                            @foreach($hasilFungsiObjektif as $key=>$value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value}}</td>
                                    <td>{{number_format(abs($hasilError[$key]), 6, '.', '')}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const tableCluster = document.querySelector('.cluster');
          const tableFungsi = document.querySelector('.fo');
          const tableSapi = document.querySelector('.sapi');

          if (tableCluster) {
              new simpleDatatables.DataTable(tableCluster);
          }

          if (tableFungsi) {
              new simpleDatatables.DataTable(tableFungsi);
          }
          if (tableSapi) {
              new simpleDatatables.DataTable(tableSapi);
          }
      });
    </script>
@endsection
