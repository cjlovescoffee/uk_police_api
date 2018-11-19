@extends('layouts.master')

@php
require_once('../resources/api/police.php');
$POLICE = new Police();
$force = $POLICE->force($id);
@endphp

@section('main')
  <section>
    <div class="container">
      <h1>{{$force['name']}}</h1>

      @if($force['description'])
        <p>{!!$force['description']!!}</p>
      @endif

      @if($force['url'])
        <p>Website: <a href="{{$force['url']}}" target="_blank">{{$force['url']}}</a></p>
      @endif

      @if($force['telephone'])
        <p>Telephone: <a href="tel:{{$force['telephone']}}">{{$force['telephone']}}</a></p>
      @endif

    </div>
  </section>

  @php
    $neighbourhoods = $POLICE->neighbourhoods($id);
  @endphp

  @if($neighbourhoods)
  <section>
    <div class="container">
      <ul>
        @foreach($neighbourhoods as $neighbourhood)
          <li><a href="/neighbourhoods/{{$neighbourhood['id']}}">{{$neighbourhood['name']}}</a></li>
        @endforeach
      </ul>
    </div>
  </section>
  @endif

@endsection