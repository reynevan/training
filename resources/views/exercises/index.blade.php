@extends('app')

@section('content')

  <div class = 'exercises'>
    <table class = 'table'>
      <thead>
        <tr>
          <th>Id.</th>
          <th>Nazwa</th>
          <th>Maks. ilość w jednej serii</th>
          <th>Łączna ilość powtórzeń</th>
          <th>Ostatnio ćwiczone</th>
        </tr>
      </thead>
      <tbody>
      @if (count($exercises))
        @foreach($exercises as $exercise)
          @include('partials._exercise', ['exercise' => $exercise])
        @endforeach
      @endif
      </tbody>
    </table>
    <button class = 'btn btn-success add-exercise'>Dodaj ćwiczenie</button>
  </div>
@stop