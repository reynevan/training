(function() {
  jQuery(function($) {
    var $newExc;
    $newExc = $('.new-exercise').clone();
    return $('.add-exercise').click(function() {
      return $newExc.appendTo($('.table-exercises')).find('input').focus();
    });
  });

}).call(this);

//# sourceMappingURL=exercises.js.map