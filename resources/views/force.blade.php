@extends('layouts.master')
@php
require_once('../resources/api/policedb.php');
$policedb = new PoliceDB();
$policedb->updateSearches($force);
$current = $policedb->force($force);
$neighbourhoods = $policedb->neighbourhoods($force);
$stopsearch = $policedb->stopAndSearchByForceAndDate($force, "2018-10");
@endphp
@section('main')
  <section>
    <div class="container">
      <h1>{{$current['name']}}</h1>
    </div>
  </section>

  @if($neighbourhoods)
  <section>
    <div class="container">
      <ul>
        @foreach($neighbourhoods as $neighbourhood)
          <li><a href="/forces/{{$force}}/{{$neighbourhood['id']}}">{!!$neighbourhood['name']!!}</a></li>
        @endforeach
      </ul>
    </div>
  </section>
  @endif

    @foreach($stopsearch as $obj)
<pre>
      {{ print_r($obj) }}
    </pre>
      @php

      @endphp

    @endforeach



@endsection
