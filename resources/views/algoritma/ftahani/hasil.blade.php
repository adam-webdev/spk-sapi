@extends('layouts.layoutmaster')
@section('content')
<style>
    table {
        width: 100%; /* Optional: membuat tabel memenuhi lebar */
        border-collapse: collapse; /* Menghilangkan jarak antar border */
    }

    th, td {
        text-align: center; /* Pusatkan teks secara horizontal */
    }

    th {
        background-color: #f2f2f2; /* Optional: memberi warna pada header */
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="d-flex justify-content-between ">
                              <h5 class="card-title">Data Hasil Hitung Fuzzy Tahani Berdasarkan Query</h5>
                              <div class="mt-3">
                                <a href="{{route('fuzzy-tahani.create')}}"  class="btn  button-tambah"><i class="fa fa-plus-circle"></i> Query / Cari Data Baru
                                </a>
                              </div>
                            </div>
                            <div class="row">
                                <p><i>Query : Jenis Sapi : <b>{{$jenis}}, </b> </b>Umur: <b>{{$umur}}, </b> Bobot : <b>{{$berat}} </i></p>
                            </div>
                            <table class="table datatable  table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Jenis Sapi</th>
                                    <th rowspan="2">Usia (bln)</th>
                                    <th rowspan="2">Berat (kg)</th>
                                    <th colspan="3" class="text-center" >Keanggotaan Umur</th>
                                    <th colspan="3" class="text-center" >Keanggotaan Bobot</th>

                                </tr>
                                <tr>
                                    <th>Muda</th>
                                    <th>Dewasa</th>
                                    <th>Tua</th>
                                    <th>Ringan</th>
                                    <th>Sedang</th>
                                    <th>Berat</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($result as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item['id']}}</td>
                                        <td>{{$item['jenis_sapi']}}</td>
                                        <td>{{$item['umur_asli']}}</td>
                                        <td>{{$item['bobot_asli']}}</td>
                                        <td>{{$item['keangotaan_umur']['muda']}}</td>
                                        <td>{{$item['keangotaan_umur']['dewasa']}}</td>
                                        <td>{{$item['keangotaan_umur']['tua']}}</td>

                                        <td>{{$item['keanggotaan_berat']['ringan']}}</td>
                                        <td>{{$item['keanggotaan_berat']['sedang']}}</td>
                                        <td>{{$item['keanggotaan_berat']['berat']}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
