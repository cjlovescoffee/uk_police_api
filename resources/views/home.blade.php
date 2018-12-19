@extends('layouts.master')

@php
require_once('../resources/api/policedb.php');
$policedb = new PoliceDB();
$forces = $policedb->forces();
$force = $policedb->force('derbyshire');
$searches = $policedb->stopAndSearchByForce($force);
@endphp

@section('main')
  <section class="py-3">
    <div class="container">
      <h2 class="h4 mb-3">Showing "Stop And Search" Records For: {{ $force['name'] }}</h2>
      <p>A summary of all records between {{ $policedb->first_updated->format('F Y') }} and {{ $policedb->last_updated->format('F Y') }}.</p>
      <div class="row">
        <div class="col-12 col-md-4 mt-3">
          <canvas id="ethnicity" width="100" height="100"></canvas>
        </div>
        <div class="col-12 col-md-4 mt-3">
          <canvas id="gender" width="100" height="100"></canvas>
        </div>
        <div class="col-12 col-md-4 mt-3">
          <canvas id="clothing" width="100" height="100"></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="py-3">
    <div class="container">
      <table class="table table-responsive table-hover compact" id="searches">
        <thead>
          <tr>
            <th>Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Gender</th>
            <th>Age Range</th>
            <th>Ethnicity</th>
            <th>Legislation</th>
            <th>Removal Of More Than Outer Clothing</th>
          </tr>
        </thead>
        <tbody>
          @foreach($searches as $search)
            @php
              $date = new DateTime($search['datetime']);
            @endphp
            <tr>
              <td>{{ $search['type'] }}</td>
              <td>{{ $date->format("d-m-Y") }}</td>
              <td>{{ $date->format("H:i") }}</td>
              <td>{{ $search['latitude'] . ', ' . $search['longitude'] }}</td>
              <td>{{ $search['gender'] }}</td>
              <td>{{ $search['age_range'] }}</td>
              <td>{{ $search['officer_defined_ethnicity'] }}</td>
              <td>{{ $search['legislation'] }}</td>
              <td>{{ $search['removal_of_more_than_outer_clothing'] ? 'Yes' : 'No' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
@endsection
