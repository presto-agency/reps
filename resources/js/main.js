

//search


// $(this).siblings('.search_input').hide();
//
// $('.search  button').on('click',function(){
//     if($(this).siblings('.search_input').is(":visible")){
//         $(this).siblings('.search_input').hide();
//     }
//     else $(this).siblings('.search_input').show();
// });

$('.search_img').click(function(event) {
    event.preventDefault();
    $('.button_input').addClass('active_button_input');
//    $('.mob_menu').removeClass('menuOff-active');
});

// $('body').click(function () {
//     $('.button_input').removeClass('active_button_input');
// });



/*accordion replays script   start*/
/*const accordionState = JSON.parse(localStorage.getItem('accordionState')) || {};

for (let key in accordionState){
    if(accordionState[key]){
        $('[data-id='+key+']').children("ul").slideUp();
        $('[data-id='+key+']').children("i").addClass('fa-plus-square');
    }else {
        $('[data-id='+key+']').children("ul").slideDown();
        $('[data-id='+key+']').children("i").removeClass('fa-plus-square');
    }
}
$('.js-category-title-for-accordion').click(function(event) {
    const group = $(event.target).data('group').split(',') || [];
    const localTree = {};
    group.forEach(item=>{
        localTree[item] = false;
    });
    localStorage.setItem('accordionState', JSON.stringify(localTree));
});

$('.js-accordionReplays-item').click(function(event) {
    const element = $(event.target).closest('li');

    if (element.find('ul').length === 0) return true;

    event.preventDefault();
    element.children("ul").slideToggle();
    element.children("i").toggleClass('fa-plus-square');
    const id = element.data("id");

    const is_hidden = element.children("i").hasClass('fa-plus-square');
    accordionState[id] = is_hidden;

    localStorage.setItem('accordionState', JSON.stringify(accordionState));
});*/
/*accordion replays    end*/




/*=======accordion replays script   start=======*/
$('.js-accordion-title').click(function(event) {
    const element = $(event.target).closest('.topic__header');
    event.preventDefault();
    element.children(".header__title").toggleClass('header__title-active');
    element.children("i").toggleClass('fa-ellipsis-h');
});
/*=======accordion replays    end=======*/

/*=======select2 script   start=======*/
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
/*=======select2 script    end=======*/


/*=======show/hide vote result in user page  start=======*/
$(document).ready(function(){
    $(".js-body__view-results").click(function(event){
        const element = $(event.target).closest('.content__body');
        event.preventDefault();
        element.children(".vote-form").hide();
        element.children(".view-results").show();
    });
});
/*=======show/hide vote result in user page  end=======*/


// Replace the textarea #example with SCEditor
var textarea = document.getElementById('video_iframe');
sceditor.create(textarea, {
    format: 'bbcode',
    toolbar: 'youtube',
    style: 'js/minified(sceditor-2.1.3)/themes/content/default.min.css'
});



