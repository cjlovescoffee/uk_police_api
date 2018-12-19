@extends('layouts.master')
@php
require_once('../resources/api/policedb.php');
$policedb = new PoliceDB();
$policedb->updateForces();
$forces = $policedb->forces();
@endphp
@section('main')
  <section>
    <div class="container">
      <ul>
        @foreach($forces as $force)
        <li><a href="/forces/{{$force['id']}}">{{html_entity_decode($force['name'], ENT_QUOTES | ENT_XML1, 'UTF-8')}}</a></li>
        @endforeach
      </ul>
    </div>
  </section>
@endsection
