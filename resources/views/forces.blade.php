@extends('layouts.master')
@php
  require_once('../resources/api/police.php');
  $POLICE = new Police();
  $forces = $POLICE->forces();
@endphp
@section('main')
  <section>
    <div class="container">
      <ul>
        @foreach($forces as $force)
          <li><a href="/forces/{{$force['id']}}">{{$force['name']}}</a></li>
        @endforeach
      </ul>
    </div>
  </section>
@endsection
