@unless($training)
  <button class='btn btn-success btn-new-training'>Nowy trening</button>
@endunless
<div class = "new-training {{$training ? 'ongoing' : ''}}" {{$training ? 'id='.$training->id : '' }}>
@if ($training)
  <div class='training-title'>Trening rozpoczęty: {{$training->started}}</div>
@endif
<table class = "table table-hover">
  <thead>
    <tr>
      <th></th>
      <th>Ćwiczenie</th>
      @if ($training)
        @foreach ($training->series()->get() as $serie)
          <th class = 'serie-title'>
            Seria {{$serie->serie_number}}
            @unless ($serie->serie_number == 1) 
              <a href="#" title = "Usun serię" class = 'btn-danger btn-serie-remove' data-serie = '{{$serie->serie_number}}'>x</a>
            @endunless
          </th>
        @endforeach 
      @else
          <th class = 'serie-title'>Seria 1</button></th>
          <th class = 'serie-title'>Seria 2 <a href="#" title = "Usun serię"  class = 'btn-danger btn-serie-remove' data-serie='2'>x</a></th>
      @endif
    </tr>
  </thead>
  <tbody>
    <tr class ='refExercise' style = 'display: none'>
      <td>
        <button class='btn btn-danger btn-exercise-remove'>
          Usuń
        </button>
      </td>
      <td>
        <select class = 'form-control'>
          <option value="0" selected>-</option>
          @foreach ($exercises as $exercise)
            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
          @endforeach
        </select>
      </td>
      <td><input type='number' min = '0' class = 'form-control' value = '0'></td>
      <td><input type='number' min = '0' class = 'form-control' value = '0'></td>                
    </tr>
    @if ($training && count($training->exercises()))
      @foreach ($training->exercises() as $trainingExercise)
        <tr>
          <td>
            <button class='btn btn-danger btn-exercise-remove'>
              Usuń
            </button>
          </td>
          <td id='{{$trainingExercise->exercise()->id}}'>
            {{ $trainingExercise->exercise()->name }}
          </td>
          @foreach ($training->series()->get() as $serie)
            <td>
              <input type='number' min = '0' class = 'form-control' 
                value = '{{ $serie->exercise($trainingExercise->exercise()->id)->first()->repeats }}'>
            </td>
          @endforeach          
        </tr>
      @endforeach
    @else
      <tr>
        <td>
          <button class='btn btn-danger btn-exercise-remove'>Usuń</button>
        </td>
        <td>
          <select class = 'form-control'>
            <option value="0" selected>-</option>
            @foreach ($exercises as $exercise)
              <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
            @endforeach
          </select>
        </td>
        <td><input type='number' min = '0' class = 'form-control' value = '0'></td>
        <td><input type='number' min = '0' class = 'form-control' value = '0'></td>
      </tr>
    @endif
  </tbody>
</table>
@if($training)
  <button class = 'btn btn-primary btn-add-exercise' data-exLeft = '{{ count($exercises) - count($training->series->first()->exercises()->get())}}'>Dodaj ćwiczenie</button>
@else
  <button class = 'btn btn-primary btn-add-exercise' data-exLeft = '{{ count($exercises)-1}}' title = 'Dodaj kolejne ćwiczenie do tego treningu'>
    Dodaj ćwiczenie
  </button>
@endif
<button class = 'btn btn-success btn-add-serie' title = 'Dodaj kolejną serię ćwiczeń do tego treningu'>Dodaj serię</button>
<button class = 'btn btn-info btn-save-training' data-token = '{{ csrf_token() }}' title = 'Zapisz obecny stan treningu.'>Zapisz</button>
<button class = 'btn btn-info btn-warning btn-end-training' data-token = '{{ csrf_token() }}' title = 'Oznacz trening jako zakończony'>
  Zakończ
</button>
<button class = 'btn btn-danger btn-cancel-training' data-token = '{{ csrf_token() }}' title = 'Usuń ten trening'>Usuń</button>
</div>