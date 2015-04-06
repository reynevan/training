@extends('app')

@section('content')
  <div class = 'trainings'>
    @include('partials/_newTraining', ['training' => $trainingUnfinished])
    <div class = 'trainings-finished'>
      @if (count($trainingsFinished))
        @foreach ($trainingsFinished as $training)
          @include('partials/_finishedTraining', ['training' => $training])
        @endforeach      
      @endif
    </div>
    @if ($trainingsFinished)
      <div class = 'text-center'>
        {!! $trainingsFinished->render() !!}
      </div>
    @endif
  </div>
@stop

@section('script')
  <script src="/js/trainings.js"></script>
@stop