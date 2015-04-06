jQuery ($) ->
  $alert = $('<div></div>').addClass('alert')
  $newExcRow = $('.refExercise').clone().show()

  $('.btn-add-serie').click ->
    serieNo = $('.new-training table thead tr th').size()
    $('.new-training table thead tr').append($('<th>Seria '+(serieNo-1)+' <a class="btn-danger btn-serie-remove" data-serie="'+(serieNo-1)+'">x</a></th>').addClass('serie-title'));
    $('.new-training table tbody tr').append('<td></td>').each ->
      $(this).find('td').last().html("<input type='number' min = '0' class = 'form-control' value = '0'>")
    $newExcRow = $('.new-training table tbody tr').last()
  
  $(document).on 'click', '.btn-add-exercise', ->
    seriesCount = $('.new-training thead th').size()
    $row = $newExcRow.clone()
    if $row.find('td').size() < seriesCount
      for i in [$row.find('td').size()...seriesCount]
        $row.append('<td><input type="number" min = "0" class = "form-control" value = "0"></td>')
    $row.appendTo($('.new-training table tbody')).find('input').each ->
        $(this).val('0')
      ###$(this).attr('data-exleft', parseInt($(this).attr('data-exleft'))-1)
    else
      $alert.clone().text('Nie masz więcej ćwiczeń do dodania').addClass('alert-danger').appendTo($('.alerts')).delay(1000).fadeOut 200, ->
          $(this).remove()###

  $(document).on 'click', '.btn-save-training', ->
    saveTraining()


  $(document).on 'click', '.btn-exercise-remove', ->
    $(this).closest('tr').fadeOut 300, ->
      $(this).remove()

  if !$('.new-training').hasClass('ongoing')
    $('.new-training').hide()

  $(document).on 'click', '.btn-new-training', ->
    $('.btn-new-training').slideUp 300, ->
      $('.new-training').fadeIn()

  $(document).on 'click', '.btn-end-training', ->
    if !saveTraining()
      return
    token = $(this).data('token')
    training_id = $(this).parents('.new-training').attr('id')
    if (training_id)
      $.ajax({
        method: "PUT",
        url: "/trainings/"+training_id,
        data: {_token: token, ajax: true },
        error: (status, xhr) ->
          $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true)
          return
      })
        .done (msg) ->
          if msg != 'error'
            $('.trainings-finished').prepend(msg).hide().fadeIn()
            $('.new-training').slideUp 300, ->
              $('.btn-new-training').fadeIn()
    else 
      $('.new-training').fadeOut 300, ->
        $trs = $('.new-training tbody tr')
        $trs.slice(1).each ->
          $(this).remove()
        $trs.first().find('select').val('0')
        $trs.find('input').each ->
          $(this).val(0)
        $trs.find('td').each ->
          if $(this).index() > 3
            $(this).remove()
        $('.new-training table thead th').each ->
          if $(this).index() > 3
            $(this).remove()
        $('.btn-new-training').slideDown()

  $(document).on 'click', '.btn-cancel-training', ->
    training_id = $(this).parents('.new-training').attr('id')
    token = $(this).data('token')
    if (training_id)
      $.ajax({
        method: "DELETE",
        url: "/trainings/"+training_id,
        data: {_token: token, ajax: true }
      })
        .done (status) ->
          if status == 'deleted'
            $alert.alert('Trening usunięty', 'btn-info')
            $('.new-training').slideUp 300, ->
              $('.btn-new-training').fadeIn()
          else
            $alert.alert('Wystąpił błąd. Odśwież stronę.', 'btn-danger', true)
    else
      $('.new-training').slideUp 300, ->
        $('.btn-new-training').fadeIn()
      
    
  $(document).on 'click', '.btn-serie-remove', ->
    console.log $('.new-training table thead tr th').size()
    if $('.new-training table thead tr th').size() > 3
      serieNum = $(this).data('serie')
      $('.new-training table thead tr th').eq(serieNum+1).fadeOut 200, ->
        $(this).remove()
      $('.new-training table tbody tr').each ->
        $(this).find('td').eq(serieNum+1).fadeOut 200, ->
          $(this).remove()
      $('.new-training table thead tr th').each ->
        if $(this).index() >= 3
          serNum = $(this).index()-1
          $(this).attr('data-serie', serNum).html('Seria '+serNum+' <a href="#" title = "Usun serię"  class="btn-danger btn-serie-remove" data-serie="'+serNum+'">x</button>')

  $(document).on 'click', '.btn-delete-training', (e) ->
    e.preventDefault()
    training_id = $(this).data('id')
    token = $(this).data('token')
    $.ajax({
      method: 'DELETE',
      url: '/trainings/'+training_id,
      data: {_token: token}
      error: (status, xhr) ->
          $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true)
          return
    })
      .done (msg) ->
        if msg == 'deleted'
          $alert.alert('Trening usunięty', 'btn-success')
          $('#training-'+training_id).slideUp 300, ->
            $(this).remove()


  saveTraining = ->
    $alert.alert('Zapisywanie', 'btn-info', true)
    that = $('.btn-save-training')
    token = that.data('token')
    training_id = that.parents('.new-training').attr('id')
    exercNotChoose = false
    if $('.new-training tbody').find('tr').size() == 0
      $alert.alert('Dodaj jakieś ćwiczenia, bo pszypau tak', 'btn-danger')
      return false
    #if $('.new-training tbody').find('tr').size() == 1
    empty = 0
    $('.new-training tbody').find('tr').each ->
      if parseInt($(this).find('td').eq(1).find('select').val()) == 0
        empty++
    if empty == $('.new-training tbody').find('tr').size()
      #if parseInt($('.new-training tbody').find('tr').first().find('td').eq(1).find('select').val()) == 0
      $alert.alert('Wybierz jakieś ćwiczenie', 'btn-danger')
      return false
    if (training_id)
      method = "PUT"
      data = {_token: token, ajax: true, id: training_id, touch: true}
      url = "/trainings/"+training_id
    else
      method = "POST"
      data = {_token: token, ajax: true}
      url = "/trainings"
    $.ajax({
      method: method,
      url: url,
      data: data
      error: (status, xhr) ->
          $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true)
          return
    })
      .done ( msg ) -> 
        console.log 'returned: '+msg
        if isNaN(msg)
          id = training_id 
        else
          that.parents('.new-training').attr('id', msg)
          id = msg
        console.log '1 id: '+id
        
        #series save
        seriesNum = $('.new-training table thead tr').find('.serie-title').size()
        $.ajax({
          method: "POST",
          url: "/series",
          data: {_token: token, ajax: true, training_id: id, seriesNum: seriesNum }
          error: (status, xhr) ->
            $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true)
          
        })
          .done ( msg ) ->
            console.log msg
            if msg == 'saved'
              $alert.alert('Serie zapisane', 'btn-success')
            else
              $alert.alert('Wystąpił błąd', 'btn-danger', true)
              return false
        #series exercises save
        $('.new-training table tbody tr').each ->
          $tds = $(this).find('td')
          exercise_id = $tds.eq(1).find('select').val() || $tds.eq(1).attr('id')
          if parseInt(exercise_id) != 0
            series = []
            for i in [2...$tds.size()]
              series[i-1] = $tds.eq(i).find('input').val()
            $.ajax({
              method: "POST",
              url: "/series_exercises",
              data: {_token: token, ajax: true, exercise_id: exercise_id, training_id: id, series: series }
            })
              .done (msg) ->
                if msg == 'saved'
                  $alert.alert('Ćwiczenia i powtórzenia zapisane', 'btn-success')
                else
                  $alert.alert('Wystąpił błąd', 'btn-danger', true)
                  return false
  