//mob_menu

$('.burger_menu').click(function(event) {
    event.preventDefault();
    $('.mob_menu').css({"display":"block"});
    $('.nav_item').css({"transform":"translateX(0)"});
    $('.nav_item').css({"opacity":"1"});

});
function close_mob_menu() {
    if(document.getElementById('nav_menu_check').checked) {
        $('.nav_item').addClass("nav_item_act");
    } else {
        console.log(2);
    }
}
$('#nav').click(function(event) {
    event.preventDefault();
        $('.mob_menu').css({"display":"none"});

});



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

// stream_list
$('.btn_streams_list').click(function(event) {
    event.preventDefault();
    $('.svg_close').css({"visibility":"visible"});
     $('.btn_theatre_mode').css({"visibility":"hidden"});
    $('.svg_stream').css({"visibility":"hidden"});
    $('.btn_streams_list').css({"width":"0"});
    $('.btn_streams_close').css({"width":"50px"});
    $('.streams_list').addClass("open");
});
$('.btn_streams_close').click(function(event) {
    event.preventDefault();
    $('.streams_list').removeClass("open");
    $('.btn_theatre_mode').css({"visibility":"visible"});
    $('.svg_close').css({"visibility":"hidden"});
    $('.svg_stream').css({"visibility":"visible"});
    $('.btn_streams_list').css({"width":"50px"});
    $('.btn_streams_close').css({"width":"0"});
});
//big_video
$('.big_video_right').click(function(event) {
    event.preventDefault();
    $('.main_container').addClass("active_big_video");
    $('.big_video_left').css({"display":"block"});
    $('.big_video_right').css({"display":"none"});
});
$('.big_video_left').click(function(event) {
    event.preventDefault();
    $('.main_container').removeClass("active_big_video");
    $('.big_video_right').css({"display":"block"});
    $('.big_video_left').css({"display":"none"});
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
if(localStorage.getItem('nightMode')==1){
    $('body').addClass('nightMode');
}
else $('body').removeClass('nightMode');
//day-night
$('#night').click(function(event) {
    event.preventDefault();
    console.log("11");
    $('body').addClass('nightMode');
     //localStorage.setItem('nightMode', theme);
    localStorage.setItem('nightMode', 1);

    // $(':root').css('--blue', 'red');
    // document.documentElement.style.setProperty('--blue', 'green');


});
$('#day').click(function(event) {
    event.preventDefault();
    console.log("21");
    $('body').removeClass('nightMode');
    localStorage.setItem('nightMode', 2);
});

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
// var textarea = document.getElementById('video_iframe');
// sceditor.create(textarea, {
//     format: 'bbcode',
//     toolbar: 'youtube',
//     style: 'js/sceditor/themes/content/default.min.css'
// });

/*script accordion for button on tablet and mobile version*/
$(document).ready(function(){
    $("#pulse-button-info").click(function(){
        $("#left-sidebar-wrap").toggleClass("no-height", 1000, "ease");
    });
});

$(document).ready(function(){
    $("#pulse-button-top").click(function(){
        $("#right-sidebar-wrap").toggleClass("no-height", 1000, "ease");
    });
});


/*script animation for button on tablet and mobile version*/
let animateButton = function(e) {

    e.preventDefault;
    //reset animation
    e.target.classList.remove('animate');

    e.target.classList.add('animate');
    setTimeout(function(){
        e.target.classList.remove('animate');
    },700);
};

let bubblyButtons = document.getElementsByClassName("pulse-button");

for (let i = 0; i < bubblyButtons.length; i++) {
    bubblyButtons[i].addEventListener('click', animateButton, false);
}



/*accordion my topics script*/
let acc = document.getElementsByClassName("accordion-button");
let i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        let panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}
