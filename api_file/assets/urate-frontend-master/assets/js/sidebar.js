$(document).ready(function(){  
    var parent_menu = undefined;
    $('.has-child > a').each(function(){
        $(this).on('click',function(){
            var className = $(this).parent().attr('class');
            var isOpen = className.indexOf('active') >=0;
            if(parent_menu !== undefined)
                $(parent_menu).parent().removeClass('active')
            if(isOpen===false)
            $(this).parent().addClass('active');
            parent_menu = this;
        })
    });
    
    var arrMenu = window.location.href.split("/");
    var currMenu = arrMenu[arrMenu.length-1];
    var arrMenu2 = "";
    
    if(currMenu != undefined || currMenu != "undefined"){
        if (currMenu.indexOf('#') > -1)
        {
            currMenu = currMenu.slice(0, -1);
        }
        
        if (currMenu.indexOf('?') > -1)
        {
            arrMenu2 = currMenu.split("?"); 
            currMenu = arrMenu2[0];
        }
        
        if (arrMenu.length > 3)
        {                      
            currMenu = arrMenu[4];
        }
        //console.log(currMenu);
        //console.log(currMenu.indexOf("#"));
        if(currMenu.indexOf("#") > -1){
            currMenu = currMenu.slice(0, -1);
        }
        
        /* level 2 menu*/
        $('[data-menu-name = "'+currMenu+'"]').parent().parent().parent().parent().parent().addClass('active');            
        $('[data-menu-name = "'+currMenu+'"]').parent().css('border-right','5px solid #322929');
        $('[data-menu-name = "'+currMenu+'"]').parent().css('background','#322929');
        $('[data-menu-name = "'+currMenu+'"]').css('background','#322929');
        
        /* level 1 menu*/
        $('[data-menu-name = "'+currMenu+'"]').parent().parent().parent().addClass('active');
        $('[data-menu-name = "'+currMenu+'"]').css('background','#322929');
        
        var titl = $('title').html();
        var subst = $('[data-menu-name = "'+currMenu+'"]').children().next().html();
        
        $('title').html(titl+' - '+subst);
    }
});