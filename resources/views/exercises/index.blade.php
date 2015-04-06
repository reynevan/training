@extends('app')

@section('content')
  <div class = 'exercises'>
    <table class = 'table table-exercises'>
      <thead>
        <tr>
          <th>Nazwa</th>
          <th>Maks. ilość w jednej serii</th>
          <th>Łączna ilość powtórzeń</th>
          <th>Ostatnio ćwiczone</th>
          <th>Akcja</th>
        </tr>
      </thead>
      <tbody>
      @if (count($exercises))
        <?php $id = 1; ?>
        @foreach($exercises as $exercise)
          @include('partials._exercise', ['exercise' => $exercise, 'id' => $id++])
        @endforeach
      @endif
      <tr class = 'new-exercise'>
        <td class = 'name'>            
          <input type='text' class = 'input-name' id = 'name-1' autofocus>
        </td>
        <td>0</td>
        <td>0</td>
        <td> - </td>
        <td class = 'save'>
          <button class='btn btn-success btn-exercise-save' title='Zapisz' data-token='{{ csrf_token() }}' >
            Zapisz<!--<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>-->
          </button>
        </td>
      </tr>
      </tbody>
    </table>
    <button class = 'btn btn-success add-exercise' >Nowe ćwiczenie</button>
  </div>
  <div id="chart" style="width:100%; height:400px;"></div>
  @foreach ($chartExercises as $exName=>$chartExercise)
    <div class='data-exercise' style = 'display: none'>
      <span class = 'exercise-name'>{{$exName}}</span>
      @foreach ($chartExercise as $training)
        <span class='data-training'> 
          <span class='training-date'> 
            <span class = 'date-year'>{{$training['date']['year']}}</span>
            <span class = 'date-month'>{{$training['date']['month']}}</span>
            <span class = 'date-day'>{{$training['date']['day']}}</span>
            <span class = 'date-hour'>{{$training['date']['hour']}}</span>
            <span class = 'date-minutes'>{{$training['date']['minutes']}}</span>
          </span>
          @foreach ($training['series'] as $exercise_id=>$repeats)
            <span class='data-serie'>
              {{$repeats}}
            </span>
          @endforeach
        </span>
      @endforeach
    </div>
  @endforeach
@stop

@section('script')
  <script src="/js/exercises.js"></script>
  <script src="/js/highcharts.js"></script>
  <script src="/js/exerciseChart.js"></script>
@stop