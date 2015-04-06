(function() {
  jQuery(function($) {
    var $alert, $newExc;
    $alert = $('<div></div>').addClass('alert flash');
    $('.new-exercise').hide();
    $newExc = $('.new-exercise');
    $('.add-exercise').click(function() {
      return $newExc.clone().appendTo($('.table-exercises')).show().find('input').focus();
    });
    $(document).on('click', '.btn-exercise-remove', function() {
      var _id, that, token;
      that = $(this);
      _id = $(this).data('id').replace(/[^\d.]/g, "");
      token = $(this).data('token');
      return $.ajax({
        method: "DELETE",
        url: "/exercises/" + _id,
        data: {
          _token: token,
          ajax: true
        }
      }).done(function(msg) {
        return that.closest('tr').fadeOut();
      });
    });
    $(document).on('click', '.btn-exercise-save', function() {
      var name, that, token;
      that = $(this);
      name = $(this).parents('td').siblings('.name').find('input').val();
      token = $(this).data('token');
      return $.ajax({
        method: "POST",
        url: "/exercises",
        data: {
          name: name,
          _token: token,
          ajax: true
        }
      }).done(function(msg) {
        var response, val;
        if (msg === 'too short') {
          $alert.alert('Nazwa za krotka', 'alert-danger');
        }
        response = JSON.parse(msg);
        that.removeClass('btn-success btn-exercise-save').addClass('btn-danger btn-exercise-remove');
        that.attr('data-id', 'exercise-' + response['id']);
        that.text('Usuń');
        $alert.alert('Dodano ćwiczenie', 'alert-success');
        val = that.parents('td').siblings('.name').find('input').val();
        return that.parents('td').siblings('.name').html(val);
      });
    });
    return $(document).on('keydown', '.input-name', function(e) {
      if (e.keyCode === 13) {
        return $(this).parents('td').siblings('.save').find('button').click();
      }
    });
  });

}).call(this);

//# sourceMappingURL=exercises.js.map