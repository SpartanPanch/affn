jQuery(function ($) {

	// remove join form for mobile view working....
	if ($(window).width() < 769) {
		$('#desktop_form_remove_captcha_issue').remove();
	}
	// menu about is working ....
	$('.navbar ul.navbar-nav > .dropdown > a[href]').click(function () {
		var dropdown = $(this).next('.dropdown-menu');
		if (dropdown.length == 0 || $(dropdown).css('display') !== 'none') {
			if (this.href) {
				location.href = this.href;
			}
		}
	});
	// menu for mobile view working....
	if ($(window).width() > 769) {
		$('.navbar-nav .dropdown').hover(function () {
			$(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
		}, function () {
			$(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();
		});
		$('.navbar-nav .dropdown > a').click(function () {
			location.href = this.href;
		});
	}
	// desktop menu get and set id from url and offset workng.....
	jQuery('ul.dropdown-menu > li').on('click', function () {
		setTimeout(function () {
			get_id_form_url_set_offset_set();
		}, 10);
	});

	if ($(window).width() < 991) {
		// 	menu for mobile for mobile working.....
		jQuery(document).find('.dropdown-menu').addClass('show');
		jQuery('ul.dropdown-menu > li').on('click', function () {
			console.log('clicked');
			jQuery('li').removeClass('current-menu');
			jQuery(this).addClass('current-menu');
			jQuery('.dropdown-menu').removeClass('show');
			jQuery('.navbar-collapse').removeClass('show');
			jQuery('.header button.navbar-toggler').attr("aria-expanded", "false");
				setTimeout(function () {
					get_id_form_url_set_offset_set();
				}, 10);
		});
		// open sub menu on toogler button click working mobile view working.... 
		jQuery('.header button.navbar-toggler').on('click', function () {
			jQuery('.dropdown-menu').addClass('show');
		});
		// 	events page for mobile working.....
		jQuery(document).on("click", ".event-list-tabs-mobile", function () {
			if (jQuery('.event-list-tabs-mobile').hasClass("active")) {
				var id = jQuery(this).attr('id');
			}
			jQuery('.tab-pane').each(function () {
				var i = jQuery(this).attr('id');
				var i = '#' + i;
				if (id == i) {
					jQuery(this).addClass('active');
					jQuery('html').addClass('events-active');
				}
			});
		});

		
		setInterval(function () {
			jQuery(".events-back-button").on('click', function () {
				jQuery('.tab-pane-mobile').each(function () {
					if (jQuery(this).hasClass("active")) {
						jQuery(this).removeClass("active");
						jQuery('html').removeClass('events-active');
					}
				});
				jQuery('#tab-pane-mobile').each(function () {
					if (jQuery(this).hasClass("active")) {
						jQuery(this).removeClass("active");
					}
			});
				jQuery('.event-list-tabs-mobile').each(function () {
					if (jQuery(this).hasClass("active")) {
						jQuery(this).removeClass("active");
					}
				});
			});
		}, 200);

		// for members page mobile only ?
		jQuery(window).scroll(function () {
			var scroll = jQuery(window).scrollTop();
			if (scroll >= 350) {
				jQuery(".members-search-alphabets-mobile").addClass("sticky-sidebar");
			}
		});
	}
	// for hide and show result of search of serach box working.....
	setInterval(function () {
		var val1 = jQuery('.members-search-inner input').val();
		if (val1 != 0) {
			jQuery('.hide-search1').hide();
		} else {
			jQuery('.search-box .form-actions input[data-drupal-selector="edit-reset"]').hide();
			jQuery('.hide-search1').fadeIn(2500);
			// hide for "x" in serch 
			jQuery('.members-search-inner.form-actions').hide();
		}
		jQuery(document).on("keyup", ".members-search-inner input", function () {
		var value = jQuery(this).val();
			if (value != 0) {
				jQuery('.hide-search1').hide();
				jQuery('.show-onsearch1').hide();
			} else {
				jQuery('.search-box .form-actions input[data-drupal-selector="edit-reset"]').hide();
				jQuery('.hide-search1').fadeIn(2500);
				jQuery('.show-onsearch1').fadeIn(2500);
				jQuery('.members-search-inner.form-actions').hide();
			}
		});
	// this is used for check captcaha of forms and how and hide submit button on condition of checked of captc
	}, 200);
	// });
	// for members desktop
	jQuery('#remove-for-mobile .alphabets-list-desktop > a').on('click', function (event) {
		setTimeout(function () {
			event.preventDefault();
			get_id_form_url_set_offset_set2();
		}, 10);
	});
	//    for members mobile
	jQuery('#members-for-mobile .members-search-alphabets ul li ').on('click', function (event) {
		setTimeout(function () {
			event.preventDefault();
			get_id_form_url_set_offset_set();
		}, 10);
	});
	// for events page link get form url after click on home page events
	var type = window.location.hash.substr(1);
	if (type) {
		jQuery('.our-events-tabs .nav-item .nav-link').each(function () {
			var currenthref = jQuery(this).attr('href');
			var type = window.location.hash.substr(1);
			if (jQuery(currenthref == type)) {
				jQuery(this).trigger('click');
			}
		});
	}
	// header fix for
	var HeaderHeight = jQuery('.header').height();
	jQuery('.headerHeight').height(HeaderHeight);
	jQuery(window).scroll(function () {
		if (jQuery(window).scrollTop() > 0) {
			jQuery('body').addClass('fixed-header');
		} else {
			jQuery('body').removeClass('fixed-header');
		}
	});
});
jQuery(document).ready(function () {
	setInterval(function () {
		hide_button_captcha_validation();
	}, 300);

	jQuery( "#exampleModal_subscribe" ).on('shown.bs.modal', function(){
		console.log("this is running");
		hide_button_captcha_validation();
    // alert("I want this to appear after the modal has opened!");
    
});

	jQuery(document).on('show.bs.modal','#exampleModal_subscribe', function () {
		//console.log("this is runnin22g");
		grecaptcha.ready(function() {
 			 grecaptcha.render("recaptcha-container", {
    		"sitekey": "6Le18jMbAAAAACR3cwBFLl9_7fqA_hIvG0CD3ZVV"
  			});
		});

	});

		jQuery(document).on('show.bs.modal','#exampleModalsubscrib123', function () {
			//console.log("this is runnin22g");
			grecaptcha.ready(function() {
				grecaptcha.render("recaptcha-container", {
					"sitekey": "6Le18jMbAAAAACR3cwBFLl9_7fqA_hIvG0CD3ZVV"
				});
			});

		})
	var paths = window.location.pathname;
	var check = "offerings-services";
	if (paths.indexOf(check) != -1) {
		if (paths == '/offerings-services') {
			var hashcb = window.location.hash;
			if ($(window).width() > 768) {
				if (hashcb != undefined) {
					$('html, body').animate({
						scrollTop: $(hashcb).offset().top - 80
					}, 'slow');
				}
			} else {
				if (hashcb != undefined) {
					$('html, body').animate({
						scrollTop: $(hashcb).offset().top - 45
					}, 'slow');
				}
			}
		}
	}
});
function hide_button_captcha_validation() {
	var $captcha = jQuery('#recaptcha'),
		response = grecaptcha.getResponse();
		jQuery('body input[name="captcha_response_join"]').val(response);
	if (response.length === 0) {
		jQuery('body input[name="captcha_response_join"]').val(response);
		jQuery('#btn-validate').hide();
		jQuery('.msg-error').text("reCAPTCHA is mandatory");
		if (!$captcha.hasClass("error")) {
			$captcha.addClass("error");
		}
	} else {
		jQuery('#btn-validate').show();
		jQuery('.msg-error').text('');
		$captcha.removeClass("error");
	}
}
// function for get id form url and set offset 
function get_id_form_url_set_offset_set() {
	var headerHeight = jQuery('.header').height();
	var PATH = window.location.hash;
	jQuery(document).scrollTop(jQuery(PATH).offset().top - headerHeight);
};
// function for get id form url and set offset 
function get_id_form_url_set_offset_set2() {
	var headerHeight = jQuery('.header').height();
	var PATH = window.location.hash;
	jQuery(document).scrollTop(jQuery(PATH).offset().top - 120);
};
function get_id_form_url_set_offset_set3() {
	var PATH = window.location.hash;
	jQuery('.offer-section .inner-pad').scrollTop(jQuery(PATH).offset().top - 500);
};

jQuery(document).ready(function(){
	let mainNavLinksDesktop = document.querySelectorAll("#navv nav ul li a");
	let mainSections = document.querySelectorAll("#mainn main section");
	window.addEventListener("scroll", event => {
		let fromTop = window.scrollY;
		mainNavLinksDesktop.forEach(link => {
			let section = document.querySelector(link.hash);
			if (
				section.offsetTop <= fromTop &&
				section.offsetTop+40 + section.offsetHeight > fromTop
			) {
				link.classList.add("current");
			} else {
				link.classList.remove("current");
			}
		});
	});

});