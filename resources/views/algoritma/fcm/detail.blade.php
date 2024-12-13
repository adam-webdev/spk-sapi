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
        <div class="col-md-5 col-sm-12">
           <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Grafik
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                                        <canvas id="clusterChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
     <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="d-flex justify-content-between ">
                            <h6 class="mt-4"><b>Hasil Cluster Sapi Berkualitas</b></h6>
                            <div class="mt-3">

                            <a href="{{ route('fcm.export',['id' => $hasilfcm->id, 'format'=>'xlsx' ]) }}" class="btn text-white" style="background: rgb(53, 162, 162)"><i class="fas fa-table"></i>Export Excel</a>
                            <a href="{{ route('fcm.export',['id' => $hasilfcm->id, 'format'=>'csv']) }}" class="btn text-white" style="background: rgb(15, 136, 136)"><i class="fas fa-file-csv"></i></i>Export
                            CSV</a>
                            </div>
                        </div>
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
                                    <td>{{$value}} ( {{$value == 2 ? 'Berkualitas' : 'Tidak Berkualitas'}})</td>
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
                                <th>Batas Error</th>
                            </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                            <tfoot>
                            <tr>
                                 <th>Iterasi</th>
                                <th>Fungsi Objektif</th>
                                <th>Batas Error</th>
                            </tr>
                            </tfoot>
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

    <script>


    document.addEventListener('DOMContentLoaded', function () {
        // Data cluster yang di-passing dari PHP

        const hasilCluster = @json($hasilfcm->hasil_cluster);
        const cluster = @json($hasilfcm->hasil_jumlah_cluster);
        const dataCluster = @json($dataCluster);
        // Membuat label dinamis sesuai jumlah cluster
        console.log(dataCluster[0]);
        // Inisialisasi grafik menggunakan Chart.js
        const ctx = document.getElementById('clusterChart').getContext('2d');
        const clusterChart = new Chart(ctx, {
           type: 'doughnut',
                    data: {
                      labels: [
                          'Berkualitas',
                        'Tidak Berkualitas',
                      ],
                      datasets: [{
                        label: 'Cluster Sapi',
                        data: [dataCluster[2],dataCluster[1] ],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                        ],
                        hoverOffset: 4
                      }]
                    },

        });
    });
</script>

@endsection
