jQuery.fn.extend({
  alert: function(text, _class, stay){ 
    $('.alert').each(function(){$(this).remove()})                
    if (!stay)
      return $(this).clone().text(text).addClass(_class).appendTo($('.alerts')).delay(1000).slideUp(200, function(){$(this).remove()})
    else
      return $(this).clone().text(text).addClass(_class).appendTo($('.alerts'))
  }
})