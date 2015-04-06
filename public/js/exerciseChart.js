(function() {
  jQuery(function($) {
    var exercises;
    exercises = [];
    $('.data-exercise').each(function() {
      var $exercise;
      $exercise = $(this);
      exercises[$exercise.index() - 2] = {};
      exercises[$exercise.index() - 2]['name'] = $exercise.find('.exercise-name').text();
      exercises[$exercise.index() - 2]['data'] = [];
      return $exercise.find('.data-training').each(function() {
        var $training;
        $training = $(this);
        exercises[$exercise.index() - 2]['data'][$training.index() - 1] = [];
        exercises[$exercise.index() - 2]['data'][$training.index() - 1][0] = Date.UTC(parseInt($training.find('.date-year').text()), parseInt($training.find('.date-month').text()) - 1, parseInt($training.find('.date-day').text()), parseInt($training.find('.date-hour').text()), parseInt($training.find('.date-minutes').text()));
        exercises[$exercise.index() - 2]['data'][$training.index() - 1][1] = 0;
        return $(this).find('.data-serie').each(function() {
          return exercises[$exercise.index() - 2]['data'][$training.index() - 1][1] += parseInt($(this).text());
        });
      });
    });
    console.log(exercises);
    return $('#chart').highcharts({
      chart: {
        zoomType: 'x'
      },
      title: {
        text: ''
      },
      xAxis: {
        type: 'datetime',
        dateTimeLabelFormats: {
          month: '%e. %b',
          year: '%b'
        },
        minRange: 2
      },
      yAxis: {
        title: {
          text: 'Ilość powtórzeń w całym treningu'
        }
      },
      series: exercises
    });
  });

}).call(this);

//# sourceMappingURL=exerciseChart.js.map