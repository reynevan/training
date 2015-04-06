(function() {
  jQuery(function($) {
    var $alert, $newExcRow, saveTraining;
    $alert = $('<div></div>').addClass('alert');
    $newExcRow = $('.refExercise').clone().show();
    $('.btn-add-serie').click(function() {
      var serieNo;
      serieNo = $('.new-training table thead tr th').size();
      $('.new-training table thead tr').append($('<th>Seria ' + (serieNo - 1) + ' <a class="btn-danger btn-serie-remove" data-serie="' + (serieNo - 1) + '">x</a></th>').addClass('serie-title'));
      $('.new-training table tbody tr').append('<td></td>').each(function() {
        return $(this).find('td').last().html("<input type='number' min = '0' class = 'form-control' value = '0'>");
      });
      return $newExcRow = $('.new-training table tbody tr').last();
    });
    $(document).on('click', '.btn-add-exercise', function() {
      var $row, i, j, ref, ref1, seriesCount;
      seriesCount = $('.new-training thead th').size();
      $row = $newExcRow.clone();
      if ($row.find('td').size() < seriesCount) {
        for (i = j = ref = $row.find('td').size(), ref1 = seriesCount; ref <= ref1 ? j < ref1 : j > ref1; i = ref <= ref1 ? ++j : --j) {
          $row.append('<td><input type="number" min = "0" class = "form-control" value = "0"></td>');
        }
      }
      return $row.appendTo($('.new-training table tbody')).find('input').each(function() {
        return $(this).val('0');
      });

      /*$(this).attr('data-exleft', parseInt($(this).attr('data-exleft'))-1)
          else
      $alert.clone().text('Nie masz więcej ćwiczeń do dodania').addClass('alert-danger').appendTo($('.alerts')).delay(1000).fadeOut 200, ->
          $(this).remove()
       */
    });
    $(document).on('click', '.btn-save-training', function() {
      return saveTraining();
    });
    $(document).on('click', '.btn-exercise-remove', function() {
      return $(this).closest('tr').fadeOut(300, function() {
        return $(this).remove();
      });
    });
    if (!$('.new-training').hasClass('ongoing')) {
      $('.new-training').hide();
    }
    $(document).on('click', '.btn-new-training', function() {
      return $('.btn-new-training').slideUp(300, function() {
        return $('.new-training').fadeIn();
      });
    });
    $(document).on('click', '.btn-end-training', function() {
      var token, training_id;
      if (!saveTraining()) {
        return;
      }
      token = $(this).data('token');
      training_id = $(this).parents('.new-training').attr('id');
      if (training_id) {
        return $.ajax({
          method: "PUT",
          url: "/trainings/" + training_id,
          data: {
            _token: token,
            ajax: true
          },
          error: function(status, xhr) {
            $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true);
          }
        }).done(function(msg) {
          if (msg !== 'error') {
            $('.trainings-finished').prepend(msg).hide().fadeIn();
            return $('.new-training').slideUp(300, function() {
              return $('.btn-new-training').fadeIn();
            });
          }
        });
      } else {
        return $('.new-training').fadeOut(300, function() {
          var $trs;
          $trs = $('.new-training tbody tr');
          $trs.slice(1).each(function() {
            return $(this).remove();
          });
          $trs.first().find('select').val('0');
          $trs.find('input').each(function() {
            return $(this).val(0);
          });
          $trs.find('td').each(function() {
            if ($(this).index() > 3) {
              return $(this).remove();
            }
          });
          $('.new-training table thead th').each(function() {
            if ($(this).index() > 3) {
              return $(this).remove();
            }
          });
          return $('.btn-new-training').slideDown();
        });
      }
    });
    $(document).on('click', '.btn-cancel-training', function() {
      var token, training_id;
      training_id = $(this).parents('.new-training').attr('id');
      token = $(this).data('token');
      if (training_id) {
        return $.ajax({
          method: "DELETE",
          url: "/trainings/" + training_id,
          data: {
            _token: token,
            ajax: true
          }
        }).done(function(status) {
          if (status === 'deleted') {
            $alert.alert('Trening usunięty', 'btn-info');
            return $('.new-training').slideUp(300, function() {
              return $('.btn-new-training').fadeIn();
            });
          } else {
            return $alert.alert('Wystąpił błąd. Odśwież stronę.', 'btn-danger', true);
          }
        });
      } else {
        return $('.new-training').slideUp(300, function() {
          return $('.btn-new-training').fadeIn();
        });
      }
    });
    $(document).on('click', '.btn-serie-remove', function() {
      var serieNum;
      console.log($('.new-training table thead tr th').size());
      if ($('.new-training table thead tr th').size() > 3) {
        serieNum = $(this).data('serie');
        $('.new-training table thead tr th').eq(serieNum + 1).fadeOut(200, function() {
          return $(this).remove();
        });
        $('.new-training table tbody tr').each(function() {
          return $(this).find('td').eq(serieNum + 1).fadeOut(200, function() {
            return $(this).remove();
          });
        });
        return $('.new-training table thead tr th').each(function() {
          var serNum;
          if ($(this).index() >= 3) {
            serNum = $(this).index() - 1;
            return $(this).attr('data-serie', serNum).html('Seria ' + serNum + ' <a href="#" title = "Usun serię"  class="btn-danger btn-serie-remove" data-serie="' + serNum + '">x</button>');
          }
        });
      }
    });
    $(document).on('click', '.btn-delete-training', function(e) {
      var token, training_id;
      e.preventDefault();
      training_id = $(this).data('id');
      token = $(this).data('token');
      return $.ajax({
        method: 'DELETE',
        url: '/trainings/' + training_id,
        data: {
          _token: token
        },
        error: function(status, xhr) {
          $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true);
        }
      }).done(function(msg) {
        if (msg === 'deleted') {
          $alert.alert('Trening usunięty', 'btn-success');
          return $('#training-' + training_id).slideUp(300, function() {
            return $(this).remove();
          });
        }
      });
    });
    return saveTraining = function() {
      var data, empty, exercNotChoose, method, that, token, training_id, url;
      $alert.alert('Zapisywanie', 'btn-info', true);
      that = $('.btn-save-training');
      token = that.data('token');
      training_id = that.parents('.new-training').attr('id');
      exercNotChoose = false;
      if ($('.new-training tbody').find('tr').size() === 0) {
        $alert.alert('Dodaj jakieś ćwiczenia, bo pszypau tak', 'btn-danger');
        return false;
      }
      empty = 0;
      $('.new-training tbody').find('tr').each(function() {
        if (parseInt($(this).find('td').eq(1).find('select').val()) === 0) {
          return empty++;
        }
      });
      if (empty === $('.new-training tbody').find('tr').size()) {
        $alert.alert('Wybierz jakieś ćwiczenie', 'btn-danger');
        return false;
      }
      if (training_id) {
        method = "PUT";
        data = {
          _token: token,
          ajax: true,
          id: training_id,
          touch: true
        };
        url = "/trainings/" + training_id;
      } else {
        method = "POST";
        data = {
          _token: token,
          ajax: true
        };
        url = "/trainings";
      }
      return $.ajax({
        method: method,
        url: url,
        data: data,
        error: function(status, xhr) {
          $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true);
        }
      }).done(function(msg) {
        var id, seriesNum;
        console.log('returned: ' + msg);
        if (isNaN(msg)) {
          id = training_id;
        } else {
          that.parents('.new-training').attr('id', msg);
          id = msg;
        }
        console.log('1 id: ' + id);
        seriesNum = $('.new-training table thead tr').find('.serie-title').size();
        $.ajax({
          method: "POST",
          url: "/series",
          data: {
            _token: token,
            ajax: true,
            training_id: id,
            seriesNum: seriesNum
          },
          error: function(status, xhr) {
            return $alert.alert('Wystąpił błąd. Odśwież stronę i spróbuj ponownie.', 'btn-danger', true);
          }
        }).done(function(msg) {
          console.log(msg);
          if (msg === 'saved') {
            return $alert.alert('Serie zapisane', 'btn-success');
          } else {
            $alert.alert('Wystąpił błąd', 'btn-danger', true);
            return false;
          }
        });
        return $('.new-training table tbody tr').each(function() {
          var $tds, exercise_id, i, j, ref, series;
          $tds = $(this).find('td');
          exercise_id = $tds.eq(1).find('select').val() || $tds.eq(1).attr('id');
          if (parseInt(exercise_id) !== 0) {
            series = [];
            for (i = j = 2, ref = $tds.size(); 2 <= ref ? j < ref : j > ref; i = 2 <= ref ? ++j : --j) {
              series[i - 1] = $tds.eq(i).find('input').val();
            }
            return $.ajax({
              method: "POST",
              url: "/series_exercises",
              data: {
                _token: token,
                ajax: true,
                exercise_id: exercise_id,
                training_id: id,
                series: series
              }
            }).done(function(msg) {
              if (msg === 'saved') {
                return $alert.alert('Ćwiczenia i powtórzenia zapisane', 'btn-success');
              } else {
                $alert.alert('Wystąpił błąd', 'btn-danger', true);
                return false;
              }
            });
          }
        });
      });
    };
  });

}).call(this);

//# sourceMappingURL=trainings.js.map