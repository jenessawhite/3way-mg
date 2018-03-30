export default {
  init() {
    // JavaScript to be fired on all pages
    $(document).ready(function(){
      var scrollTop = 0;
      $(window).scroll(function(){
        scrollTop = $(window).scrollTop();
         $('.counter').html(scrollTop);
        
        if (scrollTop >= 100) {
          $('#bs4navbar').addClass('scrolled-nav');
        } else if (scrollTop < 100) {
          $('#bs4navbar').removeClass('scrolled-nav');
        } 
        
      }); 
      
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
