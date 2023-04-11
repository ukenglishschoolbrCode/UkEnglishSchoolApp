"use strict";

(function ($) {
  $(window).on('load', function () {
    t_carousel();
  });

  function t_carousel() {
    var owlRtl = false;

    if ($('body').hasClass('rtl')) {
      owlRtl = true;
    }

    $('.stm_testimonials_wrapper_style_6').each(function () {
      if ($(this).children().size() < 2) {
        $(this).closest('.testimonials_main_wrapper').find('.testimonials_control_bar').hide();
        return;
      }

      var $this = $(this);
      var owl = $this.owlCarousel({
        rtl: owlRtl,
        nav: false,
        dots: true,
        dotsContainer: '#carousel-custom-dots',
        items: 1,
        autoplay: true,
        autoplayHoverPause: true,
        loop: false,
        slideBy: 1,
        mouseDrag: false
      });
      $('.testinomials_dots_image').on('click', function () {
        owl.trigger('to.owl.carousel', [$(this).index(), 300]);
      });
      $this.closest('.simple_carousel_wrapper').find('.simple_carousel_prev').on('click', function (e) {
        e.preventDefault();
        $this.trigger('prev.owl.carousel');
      });
      $this.closest('.simple_carousel_wrapper').find('.simple_carousel_next').on('click', function (e) {
        e.preventDefault();
        $this.trigger('next.owl.carousel');
      });
    });
  }
})(jQuery);