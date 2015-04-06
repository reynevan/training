@extends('app')

@section('css')
  <link href="{{ asset('/css/chartist.min.css') }}" rel="stylesheet">
@stop
@section('content')
@include('partials._exerciseInfo', ['trainings' => $trainings, 'exercise' => $exercise])

@stop

@section('script')
<script src="/js/highcharts.js"></script>
<script src="/js/exerciseChart.js"></script>
@stop