<div class = 'training-finished' id='training-{{$training->id}}'>
  <div class='training-title text-left'>
    Trening zakończony: {{$training->humanDate}}
    <a href="#" class='btn-delete-training' data-id='{{$training->id}}' data-token = '{{ csrf_token() }}'>Usuń</a>
  </div>
  
  <table class = "table">
    <thead>
      <tr class = 'active'>
        <th>Ćwiczenie</th>
        @foreach ($training->series()->get() as $serie)
          <th class = 'serie-title'>Seria {{$serie->serie_number}}</th>
        @endforeach      
      </tr>
    </thead>
    <tbody>
      @foreach ($training->series->first()->exercises()->get() as $trainingExercise)
        <tr>        
          <td id='{{$trainingExercise->exercise() ? $trainingExercise->exercise()->id : 0}}'>
            {{ $trainingExercise->exercise() ? $trainingExercise->exercise()->name : 'Ćwiczenie usunięte'}}
          </td>
          @foreach ($training->series()->get() as $serie)
            <td>
              {{ $trainingExercise->exercise() ? $serie->exercise($trainingExercise->exercise()->id)->first()->repeats : '-'}}
            </td>
          @endforeach
          
        </tr>
      @endforeach 
    </tbody>
  </table>
</div>