<tr>
  <td> {{ $exercise->name }} </td>
  <td> {{ $exercise->maxRepeats }} </td>
  <td> {{ $exercise->sumRepeats }} </td>
  <td> {{ $exercise->lastMade }} </td>
  <td>
    <button class='btn btn-danger btn-exercise-remove' data-id="exercise-{{ $exercise->id }}"
      data-token='{{ csrf_token() }}'>
      Usuń
    </button>
  </td>
</tr>