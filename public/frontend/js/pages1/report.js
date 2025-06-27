var $ = jQuery.noConflict();


$(document).ready(function () {
    $('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
    });
    
});
 function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }