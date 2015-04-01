@extends('app')

@section('content')
  @if (count($trainings))
    @foreach ($trainings as $training)
      {{ $training->id }}
    @endforeach
  @else
    @include('partials/_newTraining')
  @endif

@stop