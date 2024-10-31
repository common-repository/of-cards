(function($){  
  $(document).ready(function () {
	//$("nav ul.menu").addClass("a-menu inline-list");
  //$("nav ul.menu li ul").removeClass("menu clearfix a-menu inline-list");
 // $("nav ul.menu li ul").addClass("sub-menu");
	
    scrollWebsite();
    scrollToTop();
    slideWebsite();
    swiperCard();
    addElement();
    flipperCard();
    menuMobile();
    addHtml();
    accordionFooter();
    scrollParallax();

    $(window).on('resize',function(){
        menuMobile();
        addHtml();
        accordionFooter();
    });


    function scrollWebsite(){
      $("html").niceScroll({
        cursorcolor:"#97488c",
        cursorwidth :'8px',
        cursorborder : 'none',
        cursorborderradius:0,
        scrollspeed:150,
        mousescrollstep:8*3, 
        zindex : 9999,
      });
      if($('.video-other-playlists-item').length > 0){
        $('.video-other-playlists-item').niceScroll({
          cursorcolor:"#97488c",
          cursorwidth :'8px',
          cursorborder : 'none',
          cursorborderradius:0,
          scrollspeed:150,
          mousescrollstep:8*3, 
          zindex : 9999,
        });
      }
    }
    function menuMobile(){
        if($(window).width()< 768){
            if($('.slick-nav').length === 0){
                $('.a-menu').slicknav({
                    allowParentLinks:true, 
                    label:'',
                    prependTo: '.menu-mb'
                });
            }            
        }
    }
    function scrollToTop(){
      if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $("#back-top").hide();    
        $(window).scroll(function () {
          $("#back-top").css({dislay:'none'}).hide();
        });
      }
      // hide #back-top first
      $(window).scroll(function(){
          if ($(this).scrollTop() > 100) {
              $('#back-top').fadeIn();
          } else {
              $('#back-top').fadeOut();
          }
      });
      $('#back-top').click(function(e){
          e.preventDefault();
          $("html, body").animate({ scrollTop: 0 }, 600);
          return false;
      }); 
    }
    function slideWebsite(){
      if($('.featureSlices').length > 0){
        $('.featureSlices').owlCarousel({        
          loop:true,        
          margin:40,
          nav:true,
          responsiveClass:true,
          responsive:{
            0:{
                items:3, 
                margin:10,              
            },
            600:{
                items:3,
                margin:10,
            },
            1024:{
                items:5,
                margin:10,
                //loop:false
            },
            1200:{
                items:6,
            }
          }
        });
      }
      if($('.video-recently-list').length > 0){
        $('.video-recently-list').owlCarousel({
          loop : true,   
          animateOut: 'fadeOut',     
          navSpeed : 1000,
          nav : false,
          margin:40,
          dragEndSpeed : 1000,
          responsiveClass:true,
          responsive:{
            0:{
              items:1,              
            },
            768:{
              items:2,
            },
          }
        });
        var owlVideoRecently = $('.video-recently-list');
        owlVideoRecently.owlCarousel();
        // Go to the next item
        $('.video-recently .video-re-next').click(function(e) {
          e.preventDefault();
          owlVideoRecently.trigger('next.owl.carousel',[1000]);
        });
        // Go to the previous item
        $('.video-recently .video-re-prev').click(function(e) {
          e.preventDefault();
          owlVideoRecently.trigger('prev.owl.carousel',[1000]);
        });
      }
      if($('.video-create-list').length > 0){
        $('.video-create-list').owlCarousel({
          loop : true,
          navSpeed : 1000,
          nav : false,
          dragEndSpeed : 1000,
          items:1,        
          animateOut: 'fadeOut', 
          margin : 0,
          stagePadding : 0, 
        });
        var owlVideoPlaylist = $('.video-create-list');
        owlVideoPlaylist.owlCarousel();
        // Go to the next item
        $('.video-create-playlist .video-re-next').click(function(e) {
          e.preventDefault();
          owlVideoPlaylist.trigger('next.owl.carousel',[1500]);
        });
        // Go to the previous item
        $('.video-create-playlist .video-re-prev').click(function(e) {
          e.preventDefault();
          owlVideoPlaylist.trigger('prev.owl.carousel',[1500]);
        });
      }
      if($('.slide-meet-angel').length > 0){
        $('.slide-meet-angel').owlCarousel({
          loop: true,
          nav: false,
          dots: false,
          items:1,        
          animateOut: 'fadeOut', 
          autoplay: true,
          autoplayTimeout : 3000
        });
      }
    }
    function swiperCard(){
      if($('.list-oracle-card').length > 0){
        var htmlElement='',htmlFirst;
        $('.swiper-wrapper .swiper-slide').each(function (e){
          if($(this).index() === 0){
            htmlFirst = '<li>'+$(this).html()+'</li>';
          }else{
            htmlElement += '<li>'+$(this).html()+'</li>';
          }         
        });
        $('.list-oracle-card').append('<ul class="baraja-container hideSlide"></ul><ul class="html-first hideSlide"></ul><ul class="html-full hideSlide"></ul><a hre="#" class="fanOther2 hideSlide"></a>');
        $('.baraja-container').html(htmlFirst);
        $('.html-first').html(htmlFirst);
        $('.html-full').html(htmlElement);
        var opStretch = 75,opDepth = 150;        
        if($(window).width() < 767){
          opStretch = 25;
          opDepth = 30;
        }
        var mySwiper = new Swiper('.swiper-container',{
            paginationClickable: false,
            grabCursor: true,
            slidesPerView:3,
            loop:true,
            tdFlow: {
                rotate : 20,
                stretch :opStretch,
                depth: opDepth,
                modifier : 1
                //shadows:true
            }
        });  
        var timerLeft,timerRight;      
        $('.list-oracle-card .arrow-left').hover(function(){
          mySwiper.swipePrev();
          timerLeft = setInterval(function() {mySwiper.swipePrev();}, 500);
        },function(){
            clearInterval(timerLeft);
        });                
        $('.list-oracle-card .arrow-right').hover(function(){
          mySwiper.swipeNext();
          timerRight = setInterval(function() {mySwiper.swipeNext();}, 500);
        },function(){
            clearInterval(timerRight);
        });  
                
        $('.btn-shuffle').on("click", function(e){    
          e.preventDefault();      
          if(!$(this).hasClass('disabled')){
            $(this).addClass('disabled');
            $('.swiper-container').addClass('hideSlide');         
            $( '.baraja-container' ).removeClass('hideSlide');
            var htmlFull = $('.html-full').html();
            var $swp = $( '.baraja-container' ),
            barajaSw = $swp.baraja();
            barajaSw.add($(htmlFull));
          }         
        });
        $( '.fanOther2' ).on( 'click', function( event ) {
          var $swp = $( '.baraja-container' ),
          barajaSw = $swp.baraja();
          barajaSw.fan( {
            speed : 500,
            easing : 'ease-out',
            range : 360,
            direction : 'left',
            origin : { x : 50, y : 90 },
            center : false
          } );        
        } );
      }       
    }
    function addElement(){
      if($('.pager-current').length > 0){
        var htmlThis = $('.pager-current').html();
        var newHtml = '<span>'+htmlThis+'</span>';
        $('.pager-current').html(newHtml);
      }      
    }
    function addHtml(){
      if($('.logo-mb').length === 0){
        if($(window).width() < 768){
          var htmlSearch = $('.a-header-top .inline-list li').eq(6).html();
          $("<div class='search-mb elemntMb'>"+htmlSearch+"</div>").insertAfter($('.a-header-top .inline-list'));
          var htmlLogo = $('.a-header-top .inline-list li').eq(0).html();
          $("<div class='logo-mb elemntMb'>"+htmlLogo+"</div>").insertAfter($('.search-mb'));
        }        
      }
      if($('.video-container .title-page').length > 0 && $('.btn-more-subscribe-mb').length === 0){
        if($(window).width() < 768){
          var htmlBtn = $('.page-slidebar .btn-more-subscribe').html();
          $("<a class='btn btn-more-subscribe btn-more-subscribe-mb elemntMb' href='"+$('.page-slidebar .btn-more-subscribe').attr('href')+"'>"+htmlBtn+"</a>").insertAfter($('.video-container .title-page'));
        }
      }
      if($('.blog-list-item').length > 0 && $('.info-blog-item-time-mb').length === 0){
        if($(window).width() < 768){
          var htmlTitle = '',
          htmlReadmore = '';
          $('.blog-list .blog-list-item').each(function(){
            htmlTitle = '<div class="column info-blog-item-time-mb elemntMb"><ul class="inline-list">'+ 
                        $(this).find('.info-blog-item ul').html() + 
                        '</ul></div>';
            htmlReadmore = '<div class="column content-blog-item-readmore-mb elemntMb"><ul class="inline-list">' +
                            $(this).find('.content-blog-item ul').html() +
                            '</ul></div>' ;           
            $('<div class="row">'+htmlTitle+'</div>').insertAfter($(this).find('.info-blog-item'));
            $('<div class="row">'+htmlReadmore+'</div>').insertAfter($(this).find('.main-blog-item'));
          });
        }
      }
    }
    /*function addListStep(){
      if($('.list-steps').length > 0){
        $('.list-steps li').each(function(i){
          $(this).attr('data-no',i+1);
        });
      }
    }*/
    function flipperCard(){
      if($('.flipper').length > 0 && $(window).width()>767){
        $('.flipper').appear(function() {
          $(this).addClass('active');
        });
        
        $(".card-result-pagi li a").on('click',function(e){
          e.preventDefault();
          var idLink = $(this).attr('href');
          $("html, body").animate({ scrollTop: $(idLink).offset().top }, 600);
        });        
        var s = $(".card-result-pagi");
        var pos = s.position();
        var stickermax = $(document).outerHeight() - $("#footer").outerHeight() - s.outerHeight() + 1500;
        $(window).scroll(function() {
          var windowpos = $(window).scrollTop();
          if (windowpos >= pos.top+300 && windowpos < stickermax-300) {
            //s.attr("style", ""); //kill absolute positioning
            s.addClass("stick"); //stick it
          } else if (windowpos >= stickermax) {
            s.removeClass('stick'); //un-stick
            //s.css({position: "absolute", top: stickermax + "px"}); //set sticker right above the footer
          } else {
            s.removeClass('stick'); //top of page
          }
          if ($(this).scrollTop() <= $('#card-1').offset().top) {
            $(".card-result-pagi li").removeClass("pagi-active");
            $("#pagi-card-1").addClass("pagi-active");
          }
          if ($(this).scrollTop() >= $('#card-2').offset().top) {
            $(".card-result-pagi li").removeClass("pagi-active");
            $("#pagi-card-2").addClass("pagi-active");
          }
          if ($(this).scrollTop() >= parseInt($('#card-3').offset().top)-50) {
            $(".card-result-pagi li").removeClass("pagi-active");
            $("#pagi-card-3").addClass("pagi-active");
          }
          if ($(this).scrollTop() >= parseInt($('#card-4').offset().top)-50) {
            $(".card-result-pagi li").removeClass("pagi-active");
            $("#pagi-card-4").addClass("pagi-active");
          }
          if ($(this).scrollTop() >= parseInt($('#card-5').offset().top)-50) {
            $(".card-result-pagi li").removeClass("pagi-active");
            $("#pagi-card-5").addClass("pagi-active");
          }
        });
      }
    }
    function accordionFooter(){
      if($('.accordion-footer').length === 0 && $(window).width() < 768){
        var htmlCol = '<div class="accordion-footer elemntMb">';
        $('.footer-inner .row .column').each(function(){
          htmlCol += '<h5>'+$(this).find('h3').html()+'</h5>';
          htmlCol += '<div><ul class="'+$(this).find('ul').attr('class')+'">'+$(this).find('ul').html()+'</ul></div>';
        });
        htmlCol +='</div>';
        $('.footer-inner .container').append(htmlCol);
        $('.accordion-footer').accordion({
          collapsible: true,
          heightStyle: "content",
          active:false,          
          autoHeight: false, 
        });
      }
    }
    function scrollParallax(){
      if($(window).width()>1024){
        var s = skrollr.init({
          render: function(data) {}
        });
      }      
    }
  });
})(jQuery);