$(document).ready(function(){
    // handle links with @href started with '#' only
    $(".main-menu").on('click', 'a[href^="#"]', function(e) {
        // target element id
        var id = $(this).attr('href');

        // target element
        var $id = $(id);
        if ($id.length === 0) {
            return;
        }

        // prevent standard hash navigation (avoid blinking in IE)
        e.preventDefault();

        // top position relative to the document
        var pos = $(id).offset().top;

        // animated top scrolling
        $('body, html').animate({scrollTop: pos});
    });

    $(".more-text").hide();
    $(".read-more").click(function(e){
        e.preventDefault();
        $(this).siblings(".more-text").toggle(200);
        $(this).text($(this).text() == 'Read More >>' ? 'Read Less <<' : 'Read More >>');
        //$(this).text("Read Less <");
    })
})