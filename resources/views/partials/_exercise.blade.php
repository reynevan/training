<?php use Jenssegers\Date\Date;

Date::setLocale('pl');

?>
<tr>
  <td> {{ $exercise->name }} </td>
  <td> {{ $exercise->maxRepeats }} </td>
  <td> {{ $exercise->sumRepeats }} </td>
  <td> {{ Date::parse($exercise->updated_at)->diffForHumans() }} </td>
</tr>