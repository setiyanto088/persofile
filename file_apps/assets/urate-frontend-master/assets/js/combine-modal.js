$(document).ready(function() {
  $(".profile-selector .urate-custom-menu li").click(function() {
    if ($(this).hasClass("selected")) {
      $('#combinePanel .panel-body').prepend("<div class='urate-tag urate-profile-tag' title='"+$(this).text()+"'>"+$(this).text()+"<div class='close-tag'><div class='close-mark'></div></div></div>");
    } else {
      $('#combinePanel .panel-body').find(".urate-tag[title='"+$(this).text()+"']").remove();
    }

    logicSelector();
  });
  $("#combinePanel .panel-body").hover(function() {
    $(this).find(".close-tag").click(function() {
      var $text = $(this).closest('.urate-tag').text();
      $(this).closest('.urate-tag').remove();
      $('.profile-selector').find('li').filter(function() { return $(this).text() == $text; }).removeClass('selected');
      logicSelector();
    })
  })

  function logicSelector() {
    $('#combinePanel .panel-body .andor').remove()
    $('#combinePanel .panel-body').find('.urate-tag:not(:first-child)').before('<div class="urate-select-dropdown default andor" title="AND"><button class="urate-custom-button">AND</button><ul class="urate-custom-menu"><li><a href="#">AND</a></li><li><a href="#">OR</a></li></ul></div>');
  }

  $("#combinePanel").hover(function() {
    $('.andor .urate-custom-button').click(function() {
      console.log('man');
      $(this).closest('.urate-select-dropdown').toggleClass('active');
    });

    $('.andor .urate-custom-menu > li').click(function() {
      $(this).closest('.default').removeClass('active');
      $(this).closest('.default').attr('title', $(this).text()).children('.urate-custom-button').text($(this).text());
    });
  });

});
