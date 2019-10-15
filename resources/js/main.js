

//search
$('.search_img').click(function(event) {
    event.preventDefault();
    $('.button_input').addClass('active_button_input');
//    $('.mob_menu').removeClass('menuOff-active');
});

// user_cabinet: settings
$('#settings').click(function(event) {
    event.preventDefault();
    $('.logged_links').addClass('active');
    console.log(1);
//    $('.mob_menu').removeClass('menuOff-active');


});




     jQuery(function($){
         $(document).mouseup(function (e){ // событие клика по веб-документу

                 var div = $("#settings_div"); // тут указываем ID элемента

                 if (!div.is(e.target) // если клик был не по нашему блоку
                     && div.has(e.target).length === 0) { // и не по его дочерним элементам
                     // div.hide(); // скрываем его
                     $('.logged_links').removeClass('active');
                 }


         });
     });


//

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
/*$('.js-accordion-title').click(function(event) {
    const element = $(event.target).closest('.topic__header');
    event.preventDefault();
    element.children(".header__title").toggleClass('header__title-active');
    element.children("i").toggleClass('fa-ellipsis-h');
});*/
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



