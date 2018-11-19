@extends('layouts.master')
@php
  require_once('../resources/api/police.php');
  $POLICE = new Police();
  $forces = $POLICE->forces();
@endphp
@section('main')
  <section>
    <div class="container">
      <div class="row">
        @foreach($forces as $force)
          <pre>
            @php
              print_r($force);
            @endphp
          </pre>
        @endforeach
      </div>
    </div>
  </section>
@endsection
