// Init app
var $$ = Dom7;
var myApp = new Framework7({
    router: true,
//    dynamicPageUrl: 'content-{{index}}',
    // ... other parameters

});

// Init main view
// Initialize View
//var mainView = myApp.addView('.view-main');
var mainView = myApp.addView('.view-main', {
    domCache: true //enable inline pages
});
// Load about page:
//mainView.router.load({pageName: 'index'});

var ptrContent = $$('.pull-to-refresh-content');
/*
var mySwiper = myApp.swiper('.swiper-container', {
  pagination:'.swiper-pagination'
});
*/

//var hosturl="127.0.0.1/apk";
var hosturl="apk.revocloudserver.com";
//var hosturl="192.168.1.104/apk";
