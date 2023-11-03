(function ($) {
    $(".widget").find("button.btn-default").addClass("hidden");
    var widgetoptions = {
        animate: true
    };
    $('.grid-stack').gridstack(widgetoptions);
    $(".widget.inverse").parentsUntil($(".grid-stack")).addClass("inverse");
    $(".widget.selected").find("input[type=checkbox]").prop("checked", true);
    $(".widget").find(".urate-checkbox").click(function () {
        var checkBoxes = $(this).find("input[type=checkbox]");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    });
    $(".widget").find(".urate-checkbox>label").click(function () {
        $(this).parentsUntil($(".grid-stack")).toggleClass("selected");
    });
    $("#widget-1").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-1]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-2").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-2]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-3").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-3]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-4").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-4]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-5").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-5]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-6").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-6]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-7").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-7]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    });
    $("#widget-8").find(".urate-checkbox>label").click(function () {
        $("[data-widget=widget-8]").parentsUntil($(".grid-stack")).toggleClass("hidden");
    }); 
    $("#exportWidget").on("click", function () {
        $(this).button("complete")
            .addClass("btn-default")
            .removeClass("btn-primary");
        $(".btn-cancel").removeClass("hidden");
        $(".widget").addClass("show-checkbox");
    });
    $(".btn-cancel").on("click", function () {
		// alert(123);
		$("input:checkbox").prop('checked', $(this).removeAttr("checked"));
		$('#hs').html("");
		// return false;
		$('.urate-form-checkbox').removeAttr('checked');
        $(this).addClass("hidden");
        $("#exportWidget").button("reset")
            .addClass("btn-primary")
            .removeClass("btn-default");
        $(".widget").removeClass("show-checkbox").removeClass("selected");
    });
})(jQuery);