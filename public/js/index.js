//menu content
$(".menu-main i").click(function(){
$(".menu-dropdown").slideToggle(300);
$(".menu-main .fa-chevron-down").toggleClass("fa-chevron-up");
$(".cart-menu").css("display","none");
});
//cart content
$(".cart-numb").click(function(){
  $(".cart-menu").slideToggle(300);
  $(".menu-dropdown").css("display","none");
  $(".menu-main .fa-chevron-down").removeClass("fa-chevron-up");
 
  });
//sub category
$(".sub-categ").each(function(i){
    $(this).click(function(){
        $(".sub-categ-cont").eq(i).slideToggle(200);
        $(".sub-categ .fa-chevron-down").eq(i).toggleClass("fa-chevron-up")
        });
});
//cart
$(".cart-item-price-numb input").click(function(){
$(".update-btn").css("display","block")
});
//products
$("document").ready(function(){
var productWidth=$(".product-img img").width();
console.log(productWidth);
$(".overlay-product h5").css("width",productWidth);
});
//product imgs detail 
$('.autoplay').slick({
    slidesToShow: 1.1,
    slidesToScroll: 1,
    autoplay: true,
     arrows: false,
    autoplaySpeed: 2000,
    pauseOnHover:false,
    
  });
  //product slider
  $('.single-item').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true,
    arrows:false
  });
//spinner
$(window).on('load',function(){
    $("body").css("overflow-y","auto");
    $(".layout-spin").fadeOut(800);
    });