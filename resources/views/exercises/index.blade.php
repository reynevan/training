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
          <form>
            <input type='text' autofocus>
          </form>
        </td>
        <td>0</td>
        <td>0</td>
        <td> - </td>
      </tr>
      </tbody>
    </table>
    <button class = 'btn btn-success add-exercise'>Dodaj ćwiczenie</button>
  </div>
@stop