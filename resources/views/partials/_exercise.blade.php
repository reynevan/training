<?php use Jenssegers\Date\Date;

Date::setLocale('pl');

?>
<tr>
  <td> {{ 1 }} </td>
  <td> {{ $exercise->name }} </td>
  <td> {{ 1000 }} </td>
  <td> {{ $exercise->dupa }} </td>
  <td> {{ Date::parse($exercise->updated_at)->diffForHumans() }} </td>
</tr>