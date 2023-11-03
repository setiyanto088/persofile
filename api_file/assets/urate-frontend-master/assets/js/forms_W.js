// DROPDOWN SELECT
$(document).ready(function() {
  var $select = $('select.urate-select');
  var $open;
  
  $select.each(function() {

    var $classes = '';
    var $options = $(this).children();

    if ($(this).hasClass('multiple-menu')) {
      $classes += ' multiple-menu';
    } else if ($(this).hasClass('grid-menu')) {
      $classes += ' grid-menu';
    } else {
      $classes += ' default';
    }

    $(this).after("<div class='urate-select-dropdown"+$classes+"' data-id='"+this.id+"'></div>");

    $(this).next('.urate-select-dropdown').append("<button class='urate-custom-button' data-id='"+this.id+"'>"+$(this).attr("title")+"</button>").append("<ul class='urate-custom-menu'></ul>");

    var $target = [];
    var ind = 0;

    $options.each(function() {
      $target[ind] = $(this).attr('data-target');
      ind++;
    });

    for (var i=0; i<$options.length; i++) {
      if (!($target[i]==null)) {
        $(this).next('.urate-select-dropdown').find("ul.urate-custom-menu").append("<li class='modal-link'><a href='#' data-toggle='modal' data-target='"+$target[i]+"' data-real='"+$options[i].value+"' data-id='"+this.id+"'>"+$options[i].text+"</a></li>");
      } else {
        $(this).next('.urate-select-dropdown').find("ul.urate-custom-menu").append("<li><a href='#' data-real='"+$options[i].value+"' data-id='"+this.id+"'>"+$options[i].text+"</a></li>");
      }
    }
    
    //$(this).remove();
  });

  $('.urate-custom-button').click(function(event) {       
    $(".panel-body,.content-wrapper,.side-menu-wrapper,.navbar").click(function (event) {
        if($open != ''){                  
                $('.urate-custom-menu > li').closest('.default').removeClass('active');
                
                $('#'+$open).triggerHandler('blur');
                
                $open = '';
              
        }    
    }); 
    
    $(this).closest('.urate-select-dropdown').toggleClass('active'); 
    
    $open = $(this).attr('data-id');   
    event.stopPropagation();
  });                                                              

  $('.urate-custom-menu > li').click(function(event) {
    if (!($(this).find('a').attr('data-target'))) {
      $(this).closest('.default').children('.urate-custom-button').text($(this).text());
      $(this).closest('.default').find('.hidden-element-for-dropdown').attr('value', $(this).children('a').attr('data-real'));  
    }

    $(this).closest('.default').removeClass('active');
    
    $('#'+$(this).children('a').attr('data-id')).val($(this).children('a').attr('data-real'));
    $('#'+$(this).children('a').attr('data-id')).trigger('change');
    
    //$('#'+$open).off("blur");   
    //$open = '';              
    
    event.stopPropagation();            
  });

  $('.multiple-menu .urate-custom-menu > li.modal-link').click(function() {
    $(this).closest('.urate-select-dropdown').toggleClass('active');
  });

  $('.multiple-menu .urate-custom-menu > li:not(.modal-link)').click(function() {
    $(this).toggleClass('selected');

    var $strArr = [];
    var $str = [];
    var $text = '';

    $('.multiple-menu .urate-custom-menu > li').each(function() {
      if ($(this).hasClass('selected')) {
        $strArr.push($(this).children('a').attr('data-real'));
        $str.push($(this).children('a').text());
      }
    });


    for (var i = 0; i < $str.length; i++) {
      $text += '<span class="menu-item">'+$str[i]+'</span>'
    }

    $(this).closest('.multiple-menu').children('.urate-custom-button').text('').append($text);
    $(this).closest('.multiple-menu').find('.hidden-element-for-dropdown').attr('value', $strArr);
  });

  $('.grid-menu .urate-custom-menu > li.modal-link').click(function() {
    $(this).closest('.urate-select-dropdown').toggleClass('active');
  });

  $('.grid-menu .urate-custom-menu > li:not(.modal-link)').click(function() {
    $(this).toggleClass('checked');

    var $strArr = [];
    var $str = [];
    var $text ='';

    $('.grid-menu .urate-custom-menu > li').each(function() {
      if ($(this).hasClass('checked')) {
        $strArr.push($(this).children('a').attr('data-real'));
        $str.push($(this).children('a').text());
      }
    });


    for (var i = 0; i < $str.length; i++) {
      $text += '<span class="menu-item">'+$str[i]+'</span>'
    }

    $(this).closest('.grid-menu').children('.urate-custom-button').text('').append($text);
    $(this).closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', $strArr);
  });

  // LAYOUT MENU
  $('.urate-select-layout-menu').each(function() {

    var $options = $(this).children();

    var $hiddenElement = "<input type='text' class='hidden-element-for-dropdown' id='"+this.id+"' name='"+this.id+"' style='display: none;' value='"+$options[0].value+"'>";

    $(this).after("<div class='urate-select-dropdown-layout'></div>");

    $(this).next('.urate-select-dropdown-layout').append($hiddenElement).append("<button class='urate-custom-button'>"+$(this).attr("title")+"</button>").append("<ul class='urate-custom-menu'></ul>");

    for (var i=0; i<$options.length; i++) {
      $(this).next('.urate-select-dropdown-layout').find("ul.urate-custom-menu").append("<li class='selected'><a href='#' data-real='"+$options[i].value+"' data-id='"+this.id+"'>"+$options[i].text+"</a></li>");
    }


    $(this).remove();
  })

  $('.urate-select-dropdown-layout').each(function() {
    setValue($(this).find('.urate-custom-menu'));
  });

  $('.urate-custom-button').click(function() {
    $(this).closest('.urate-select-dropdown-layout').toggleClass('active');
  });

  $('.urate-select-dropdown-layout .urate-custom-menu > li').click(function() {
    $(this).toggleClass('selected');

    setValue($(this).closest('.urate-custom-menu'));
  });
  
  $('.panel-body').click(function(event){
      
  });

  function setValue($selector) {
    var $str = '';

    $selector.find('li.selected').each(function() {
      $str += $(this).find('a').attr('data-real') + ', ';
    })

    $str = $str.substring(0, $str.length-2);

    $selector.closest('.urate-select-dropdown-layout').find('.hidden-element-for-dropdown').attr('value', $str);
  }
           
  //$(window).click(function (event) {    
  $(".panel-body,.content-wrapper,.side-menu-wrapper,.navbar").click(function (event) {
      if($open != ''){                  
              $('.urate-custom-menu > li').closest('.default').removeClass('active');
              
              $('#'+$open).triggerHandler('blur');
              
              $open = '';
       
      }    
  });
});
