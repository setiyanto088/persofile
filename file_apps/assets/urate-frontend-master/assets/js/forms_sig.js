$(document).ready(function(){
    $('.urate-panel-result').hide();    
});

// DROPDOWN SELECT
$(document).ready(function() {
  var $select = $('select.urate-select');

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

    // With Default Value
    //var $hiddenElement = "<input type='text' class='hidden-element-for-dropdown' id='"+this.id+"' name='"+this.id+"' style='display: none;' value='"+$options[0].value+"'>";
    // Without Default Value
    var $hiddenElement = "<input type='text' class='hidden-element-for-dropdown' id='"+this.id+"' name='"+this.id+"' style='display: none;' value=''>";
    var id = this.id;
    $(this).after("<div class='urate-select-dropdown"+$classes+"'></div>");

    $(this).next('.urate-select-dropdown').append($hiddenElement).append("<button class='urate-custom-button urate-select-form' id='custom_"+this.id+"'>"+$(this).attr("title")+"</button>").append("<ul class='urate-custom-menu'></ul>");
    
    var $target = [];
    var ind = 0;

    $options.each(function() {
      $target[ind] = $(this).attr('data-target');
      ind++;
    });

    for (var i=0; i<$options.length; i++) {
      if (!($target[i]==null)) {
        $(this).next('.urate-select-dropdown').find("ul.urate-custom-menu").append("<li class='modal-link'><a href='javascript:void(0)' data-toggle='modal' data-target='"+$target[i]+"' data-real='"+$options[i].value+"' data-id='"+this.id+"'>"+$options[i].text+"</a></li>");
      } else {
        $(this).next('.urate-select-dropdown').find("ul.urate-custom-menu").append("<li data-for='"+this.id+"'><a href='javascript:void(0)' class='urate-select-form-two' data-real='"+$options[i].value+"' data-id='"+this.id+"'>"+$options[i].text+"</a></li>");
      }
    }

    $(this).remove();
  });

  $('.urate-custom-button').click(function() {                      
    $(this).closest('.urate-select-dropdown').toggleClass('active');  
    
    if($(this).closest('.urate-select-dropdown').hasClass('active')){
        $('#'+this.id).css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
    } else {
        $('#'+this.id).css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
    }
  });
  
  $('.urate-custom-menu > li').click(function() {  
    if (!($(this).find('a').attr('data-target'))) {
      $(this).closest('.default').children('.urate-custom-button').text($(this).text());
      $(this).closest('.default').find('.hidden-element-for-dropdown').attr('value', $(this).children('a').attr('data-real'));
    }
    $(this).closest('.default').removeClass('active');     
    //console.log($(this).parent().siblings().next().attr('id'));
    if($(this).closest('.urate-select-dropdown').hasClass('active')){
        $('#'+$(this).parent().siblings().next().attr('id')).css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
    } else {
        $('#'+$(this).parent().siblings().next().attr('id')).css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
    }
  });

  $('.multiple-menu .urate-custom-menu > li.modal-link').click(function() {
    //alert("Heloooo3");
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
    //alert("Heloooo4");
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
  //

  // LAYOUT MENU
  $('.urate-select-layout-menu').each(function() {

    var $options = $(this).children();

    var $hiddenElement = "<input type='text' class='hidden-element-for-dropdown' id='"+this.id+"' name='"+this.id+"' style='display: none;' value='"+$options[0].value+"'>";

    $(this).after("<div class='urate-select-dropdown-layout'></div>");

    $(this).next('.urate-select-dropdown-layout').append($hiddenElement).append("<button class='urate-custom-button'>"+$(this).attr("title")+"</button>").append("<ul class='urate-custom-menu'></ul>");

    for (var i=0; i<$options.length; i++) {
      $(this).next('.urate-select-dropdown-layout').find("ul.urate-custom-menu").append("<li class='selected'><a href='javascript:void(0)' class='urate-select-form-three' data-real='"+$options[i].value+"' data-id='"+this.id+"'>"+$options[i].text+"</a></li>");
    }


    $(this).remove();
  })

  $('.urate-select-dropdown-layout').each(function() {
    setValue($(this).find('.urate-custom-menu'));
  });

  $('.urate-custom-button').click(function() {
    //alert("Heloooo5");
    $(this).closest('.urate-select-dropdown-layout').toggleClass('active');
  });

  $('.urate-select-dropdown-layout .urate-custom-menu > li').click(function() {
    $(this).toggleClass('selected');

    setValue($(this).closest('.urate-custom-menu'));
  });

  function setValue($selector) {
    var $str = '';

    $selector.find('li.selected').each(function() {
      $str += $(this).find('a').attr('data-real') + ', ';
    })

    $str = $str.substring(0, $str.length-2);

    $selector.closest('.urate-select-dropdown-layout').find('.hidden-element-for-dropdown').attr('value', $str);
  }
  //

  $('[data-toggle="tab"]').on('click',function(){
      $('.dataTables_scrollHead').css('width','100%');
      $('.dataTables_scrollHeadInner').css('width','100%');
      $('.dataTables_scrollBody').css('width','100%');
      $('.dataTable').css('width','100%');
  }); 
});