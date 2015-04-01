jQuery ($) ->

  $newExc = $('.new-exercise').clone()
  $('.add-exercise').click ->
    $newExc.appendTo($('.table-exercises')).find('input').focus()

    