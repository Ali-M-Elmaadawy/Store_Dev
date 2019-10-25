//sub category at form add category
$(".sub-categ-add-btn").click(function(){
$(".sub-category-input").slideDown(500);
});
//sub category at all categories

$(document).on('click' , ".sub-categ-all-btn" , function() {

  $(this).parent().parent().parent().find(".addsubcat").slideToggle(500)

});

//sub categories at main category


$(document).on('click' , ".main-dash-categ" , function() {

  $(this).parent().find('.sub-categ-main-box').slideToggle(500);

  $(this).parent().find('.main-dash-categ .fa-chevron-down').toggleClass("fa-chevron-up");

});


  //multiple inputs in sub category
  $(document).ready(function(){
    var maxField = 50; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" class="form-control" placeholder="Sub Category Name" name="subcat[]"/><a href="javascript:void(0);" class="remove_button"><img src="imgs/remove-icon.png"/></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
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