$(document).ready(function(){
setTimeout(function(){
    $('.core-vcenter').each(function(){
        var vcpheight = $(this).parent().outerHeight();
        var vcheight = $(this).height();        
        //alert($(this).height());
        console.log(vcpheight+"xxx"+vcheight);

        $(this).css({'marginTop':(vcpheight-vcheight)/2}); 
    });  },1000);
});

$(document).ready(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 500) {
                $('.core-stick-top').fadeIn();
        }
        if($(window).scrollTop() < 500) {
            $('.core-stick-top').fadeOut();
        }
    });
});

$(document).on('click','.pe-selectbutton', function() {

    $('.pe-flug').removeClass('text-white bg-primary');
    
    $(this).closest('.pe-flug').addClass('text-white bg-primary');
    
});   

$(document).on('click','.pe-selectpilot', function() {

    $('.pe-pilot').removeClass('text-white bg-primary');
    
    $(this).closest('.pe-pilot').addClass('text-white bg-primary');
    
}); 