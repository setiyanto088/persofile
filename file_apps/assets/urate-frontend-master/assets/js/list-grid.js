
$("#listview").click(function(){
        $(".urate-box-profile").parent().addClass("list-view");
        $("#listview").addClass("active");
        $("#gridview").removeClass("active");
});
        
$("#gridview").click(function(){
        $("#gridview").addClass("active");
        $("#listview").removeClass("active");
        $(".urate-box-profile").parent().removeClass("list-view");
});