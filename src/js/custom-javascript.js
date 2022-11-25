// Add your custom JS here.
// import Swiper, { Navigation, Pagination } from 'swiper';

jQuery(document).ready(function($) {
	var body = $('body');
  var scrolled = false;
  var navbarClasses = $('#main-nav').attr('class');

  jQuery(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if (scroll >= 25) {
			body.addClass("scrolled");
      scrolled = true;
      // $('#main-nav').removeClass('navbar-dark');
      // $('#main-nav').addClass('navbar-light');
    } else {
			body.removeClass("scrolled");
      scrolled = false;
      // $('#main-nav').removeClass('navbar-light navbar-dark').addClass(navbarClasses);
    }

	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
	       body.addClass("near-bottom");
	   } else {
			body.removeClass("near-bottom");
	   }

	});

  $('#navbarNavDropdown').on('show.bs.collapse', function () {
    body.addClass('menu-open');
  });

  $('#navbarNavDropdown').on('hide.bs.collapse', function () {
    body.removeClass('menu-open');
  });

  $('.sub-menu-toggler').click(function(e) {
    e.preventDefault();
    $(this).parent().next().toggleClass('show');
    $(this).parent().parent().toggleClass('show');
  });

  $('.abrir-chat, a[href="#abrir-chat"]').click(function(e) {
    e.preventDefault();
    $('#lbContactHeaderFloat').trigger('click');
    $('#lbContactTrigger').trigger('click');
  });

  $('[href*=home-animation-slide').click(function(e) {
    e.preventDefault();
    var destinationSelector = $(this).attr('href').replace('#', '');
    var destinationClassSelector = '.' + destinationSelector;
    // if ( destinationClassSelector != '.' + destinationSelector ) {
      // $('[class*=home-animation-slide]').hide( 0, function() {
        $( '[class*=home-animation-slide]' ).fadeOut( 0 );
        $( destinationClassSelector ).fadeIn( 300 );
      // });
    // }
  });

});

function setSlideHeight(that){
  jQuery('.swiper-slide').css({height:'auto'});
      var currentSlide = that.activeIndex;
      var newHeight = jQuery(that.slides[currentSlide]).height();

      jQuery('.swiper-wrapper,.swiper-slide').css({ height : newHeight })
      that.update();
}



var swiper = new Swiper( '.slider-vertical', {
  direction: 'vertical',
  // mousewheel: true,
  mousewheel: {
    forceToAxis: true,
    sensitivity: 1,
    releaseOnEdges: true,
  },

  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },

  on:{
    init:function() {
      setSlideHeight(this);
    },
    slideChangeTransitionEnd:function() {
      setSlideHeight(this);
    }
  }

} );

var swiper = new Swiper( '.carousel', {
  loop: false,

  pagination: {
    el: '.swiper-pagination',
  },

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // scrollbar: {
  //   el: '.swiper-scrollbar',
  // }
} );


/* Carruseles */

// jQuery('.slick-slider').slick({
//   dots: true,
//   arrows: true,
//   infinite: true,
//   speed: 300,
//   slidesToShow: 1,
//   slidesToScroll: 1,
//   autoplay: true
// });

// jQuery('.slick-carousel, .wp-block-group.is-style-slick-carousel > .wp-block-group__inner-container, .wp-block-gallery.is-style-slick-carousel').slick({
//   dots: false,
//   arrows: true,
//   infinite: true,
//   speed: 300,
//   slidesToShow: 4,
//   slidesToScroll: 1,
//   autoplay: true,
//   responsive: [
//     {
//       breakpoint: 992,
//       settings: {
//         slidesToShow: 3,
//         slidesToScroll: 1
//       }
//     },
//     {
//       breakpoint: 576,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 2
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         slidesToShow: 1,
//         slidesToScroll: 1
//       }
//     }
//     // You can unslick at a given breakpoint now by adding:
//     // settings: "unslick"
//     // instead of a settings object
//   ]
// });


// REPRODUCIR VÍDEO CUANDO LLEGAS A ÉL

// (function($) {

//   $(document).ready(function() { 
  
//     var $win = $(window);
    
//     var elementTop, elementBottom, viewportTop, viewportBottom;

//     function isScrolledIntoView(elem) {
//       elementTop = $(elem).offset().top;
//       elementBottom = elementTop + $(elem).outerHeight();
//       viewportTop = $win.scrollTop();
//       viewportBottom = viewportTop + $win.height();

//       return (elementBottom > viewportTop && elementTop + 300 < viewportBottom);
//     }
    
//     if($('video').length){

//       var loadVideo;

//       $('video').each(function(){
//         $(this).attr('webkit-playsinline', '');
//         $(this).attr('playsinline', '');
//         $(this).attr('muted', 'muted');

//         $(this).attr('id','loadvideo');
//         loadVideo = document.getElementById('loadvideo');
//         loadVideo.load();
//       });

//       $win.scroll(function () { // video to play when is on viewport 
      
//         $('video').each(function(){
//           if (isScrolledIntoView(this) == true && $(this)[0].currentTime < $(this)[0].duration ) {
//               $(this)[0].play();
//           } else {
//               $(this)[0].pause();
//           }
//         });
      
//       });  // video to play when is on viewport

//     } // end .field--name-field-video
    
    
//    });
  
// })(jQuery);