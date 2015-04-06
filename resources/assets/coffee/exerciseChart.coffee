jQuery ($) ->
  exercises = []
  $('.data-exercise').each ->
    $exercise = $(this)
    exercises[$exercise.index()-2] = {}
    exercises[$exercise.index()-2]['name'] = $exercise.find('.exercise-name').text()
    exercises[$exercise.index()-2]['data'] = []
    $exercise.find('.data-training').each ->
      $training = $(this)
      exercises[$exercise.index()-2]['data'][$training.index()-1] = []
      exercises[$exercise.index()-2]['data'][$training.index()-1][0] = Date.UTC(parseInt($training.find('.date-year').text()), parseInt($training.find('.date-month').text())-1, parseInt($training.find('.date-day').text()), parseInt($training.find('.date-hour').text()), parseInt($training.find('.date-minutes').text()))
      exercises[$exercise.index()-2]['data'][$training.index()-1][1] = 0
      $(this).find('.data-serie').each ->
        exercises[$exercise.index()-2]['data'][$training.index()-1][1] += parseInt $(this).text()


  console.log exercises
  $('#chart').highcharts({
      chart: {
        zoomType: 'x',
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