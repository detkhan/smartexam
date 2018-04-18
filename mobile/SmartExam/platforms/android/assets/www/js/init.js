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

//var hosturl="127.0.0.1/smartexam";
var hosturl="smartexam.revoitmarketing.com";
//var hosturl="192.168.1.104/apk";
document.addEventListener('deviceready', function () {
    // Android customization
    cordova.plugins.backgroundMode.setDefaults({ text:'คุณกำลังสอบอยู่เวลากำลังดำเนินการไปเรื่อย ๆ '});
    // Enable background mode
    cordova.plugins.backgroundMode.enable();
    // Called when background mode has been activated
    cordova.plugins.backgroundMode.onactivate = function () {
      if (cordova.plugins.backgroundMode.wakeUp()) {
        alert("test");
      }
      //cordova.plugins.backgroundMode.unlock(alert("wakeup"));
        setTimeout(function () {
            // Modify the currently displayed notification

            cordova.plugins.backgroundMode.configure({
                text:'คุณกำลังสอบอยู่เวลากำลังดำเนินการไปเรื่อย ๆ '
            });
        }, 5000);
    }

}, false);

document.addEventListener("offline", onOffline, false);

function onOffline() {
myApp.alert("ไม่สามารถเชื่อมต่ออินเตอร์เน็ตได้", 'SMART EXAM');
}
