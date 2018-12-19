@extends('layouts.master')

@php
require_once('../resources/api/policedb.php');
$policedb = new PoliceDB();
$policedb->reset();
$policedb->updateForces();
$policedb->updateNeighbourhoods();
$policedb->updateSearches('derbyshire');
@endphp

@section('main')
  <div class="container">
    <h1>Success</h1>
  </div>
@endsection
