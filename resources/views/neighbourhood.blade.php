@extends('layouts.master')
@php
require_once('../resources/api/policedb.php');
$policedb = new PoliceDB();
$policedb->updateNeighbourhood($force, $neighbourhood);
$current = $policedb->neighbourhood($force, $neighbourhood);
$boundary = $policedb->neighbourhoodBoundary($force, $neighbourhood);

$test = array();
foreach ($boundary as $array) {
  array_push($test, implode(":", $array));
}
$test = implode(",", $test);

// $stopsearch = $policedb->stopAndSearchByPoly($test);
@endphp
@section('main')
  <section>
    <div class="container">
      <h1>{{$current['name']}}</h1>
    </div>
  </section>
  {{ var_dump($test) }}
@endsection
