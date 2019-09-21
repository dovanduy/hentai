jQuery(function($) {
    $(".icon_btn").click(function() {
        $(this).removeClass("zi_eyeslash ").addClass("zi_eye");
        $(this).siblings("input").attr("type", "text")
    })
    $(".icon_btn").mouseleave(function() {
        $(this).removeClass("zi_eye").addClass("zi_eyeslash");
        $(this).siblings("input").attr("type", "password")
    })
})