@extends('layouts.layoutmaster')

@section('content')
@include('sweetalert::alert')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between ">
                <h5 class="card-title">Fuzzy C-Means Results</h5>

              </div>
              <h1>Hasil Fuzzy C-Means</h1>
          @foreach ($changes as $change)
              <h2>Iterasi {{ $change['iteration'] }}</h2>
              <h3>Centroid:</h3>
              <table border="1">
                  <tr>
                      @foreach ($change['centroids'] as $centroid)
                          <td>{{ implode(', ', $centroid) }}</td>
                      @endforeach
                  </tr>
              </table>
              <h3>Matriks Keanggotaan:</h3>
              <table border="1">
                  @foreach ($change['membershipMatrix'] as $row)
                      <tr>
                          @foreach ($row as $value)
                              <td>{{ $value }}</td>
                          @endforeach
                      </tr>
                  @endforeach
              </table>
              <p>Fungsi Objektif: {{ $change['objectiveFunction'] }}</p>
          @endforeach

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection