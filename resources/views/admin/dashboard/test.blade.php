@extends('layouts.dashboard')

@section('content')
<section class="section">

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Result</h4>
        </div>
        <div class="card-body">
{{--          <canvas id="myChart" height="158"></canvas>--}}
        <?php
            foreach ($items as $item) {


        ?>
            <div>
               {{$item->asset_type}} {{ $item->due }} {{ date('Y-m-d H:i:s') }}
            </div>
        <?php
            }
        ?>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
