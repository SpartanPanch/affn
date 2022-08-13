(function($){
  $( document ).ready(function() {
    nav_toggle();
    history_slider();
    window_back_btn();
    members_searchalphbts();
    affn_historyflexvideo();
    trigger_events_block();
    all_section_sliders();
  });



  function clearActiveStatesInTableOfContents() {
    document.querySelectorAll('.node-id70 nav li').forEach((section) => {
      section.classList.remove('active');
    });
  }

  function nav_toggle(){
    $('.header .navbar-toggler').click(function () { 
      if($(this).hasClass('collapsed')) {
        $('body').addClass('head_nav_opened');
      }
      else {
        $('body').removeClass('head_nav_opened');
      }
    });

    if ($(window).width() < 767) {
      jQuery('.node-id1 .our-events-tabs .nav-tabs .nav-item:first-of-type a').addClass('activecls');
      jQuery('.node-id1 .our-events-tabs-content:first-of-type').addClass('activecls');

      jQuery('.our-events-tabs .nav-tabs .nav-item').each(function(){
        jQuery(this).find('a').on('click',function(){
          jQuery('.our-events-tabs .nav-tabs .nav-item a').removeClass('activecls');
          jQuery('.our-events-tabs .our-events-tabs-content').removeClass('activecls');
          jQuery(this).addClass('activecls');
          jQuery(this).parent().next().addClass('activecls');
        });
      });
    }
  }


  function history_slider(){
    $('#affn_history_slider').slick({
      dots: false,
      nav: true,
      infinite: true,
      speed: 800,
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
      {
        breakpoint: 991,
        settings: {
          nav: true
        }
      },
      {
        breakpoint: 767,
        settings: {
          nav: true
        }
      }
      ]
    });   
  }


  function members_searchalphbts(){
    $('.members-search-tabs-content .tab-content>.active').next().addClass('next-visible');
    $('.members-search-alphabets .nav-tabs a.nav-link').click(function(){
      var thisid = $(this).attr("href");
      $('.members-search-tabs-content .tab-pane').removeClass('member-active');
      $(thisid).addClass('member-active');
      $(thisid).eq(1).addClass('member-active');
      $(thisid).siblings().removeClass('next-visible');
      $(thisid).removeClass('next-visible');
      $(thisid).next().addClass('next-visible');
    });
  }

  function window_back_btn(){
    $('.back-btn').click(function(ev){
      ev.preventDefault();
      window.history.go(-1); return false;  
    });
  }

  function affn_historyflexvideo()
  {
    $('.why-affn-flex-video .play-icon').click(function () {      
      var src = $(this).data('url');
      $('#affn_what_gain').modal('show');
      $('#affn_what_gain iframe').attr('src', src);
    });
    $('#affn_what_gain .modal-close').click(function () {
      $('#affn_what_gain iframe').removeAttr('src');
    }); 
  }


  jQuery(document).on('click','.btn-prim.mail-sent-btn',function(){
    jQuery('.ui-front.webform-confirmation-modal').hide();
    jQuery('.ui-widget-overlay').hide();
  });


  setTimeout(function(){
    var inputval = jQuery('.our-news.latest-news .search-box input[name="search_api_fulltext"]').val();
    if(inputval){
      jQuery( "<div class='cross-icon'>*</div>" ).insertAfter('.our-news.latest-news .search-box input');
    }
  },300);

  $(".cross-icon").click(function(){
    $("#searchinput").val('');
  });



  function all_section_sliders(){
    if (jQuery(".node-id1").attr('id') == "nid-1") {
      if ($(window).width() < 767) {
        $('.node-id1 .our-events-tabs .nav-link.active').parent().next('.our-events-tabs-content').css('display','block');
        $('.node-id1 .our-events-tabs .nav-link').click(function(){
          $(this).parent().siblings('.our-events-tabs-content').css('display','none');
          $(this).parent().next('.our-events-tabs-content').css('display','block');
        });
        $('#home_news_slider').slick({
          dots: false,
          nav: true,
          infinite: true,
          speed: 800,
          slidesToShow: 1,
          slidesToScroll: 1,

        });

        $('#home_members_slider').slick({
          autoplay: true,
          dots: false,    
          arrow : false,
          infinite: true,
          speed: 400,  
          nav: true,
          fade: false,
          rows: 1,
          slidesToShow: 1,
          slidesToScroll: 1,
          slidesPerRow: 1,
          centerMode: true,

        });

      } else if ($(window).width() < 991) {

        $('#home_members_slider').slick({
          dots: false,   
          arrow : false,
          infinite: true,
          speed: 500,  
          nav: true,
          fade: false,
          rows: 1,
          slidesToShow: 2,
          slidesToScroll: 2,
          slidesPerRow: 2,

        });
      } else {
        $('#home_members_slider').slick({
          dots: false,
          nav: false,
          arrow : false,
          infinite: true,
          speed: 2000,
          adaptiveHeight: true,
          fade: true,
          autoplay: true,
          autoplaySpeed: 5000,
          rows: 2,
          slidesPerRow: 5,
        });
      }

    }

  }


  function trigger_events_block(){
    var type = window.location.hash.substr(1);
    if(type){
      setTimeout(function(){
        var data = jQuery('.our-events-tabs .nav-item .nav-link[href="#'+type+'"]').trigger('click');
      },300);
    }
  }

  if(jQuery(window).width() <= 767) {
    jQuery('.node-id62 .secretariat-list-row:not(:first-child) .honorary-members-col-desc ul').each(function(){
      var ul_height = jQuery(this).height();
      jQuery(this).parents('.honorary-members-col-box.d-flex').css("margin-bottom",ul_height);

    });
  }

})(jQuery);
