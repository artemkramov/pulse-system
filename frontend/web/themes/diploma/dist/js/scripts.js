(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		var getWindowDimen = {
			getWindowHi : function() {
				return $(window).height();
			},
			getWindowWi : function() {
				return $(window).width();
			}
		}
		
		// Navbar change color
		var navBackground = {
			setTransparant: function(){
				$("header").css({ background: "rgba(255, 255, 255, 0)", borderBottom: "1px solid transparent " });
			},
			setWhite: function(){
				$("header").css({ background: "rgba(255, 255, 255, 0.9)", borderBottom: "1px solid #e5e5e5" });
			}
		}
		function setNavPosition(){
		 	if( $(window).scrollTop() > 0 || $("header:hover").length > 0 ) {  //$("header").is(':hover') === true ) {  
		 		navBackground.setWhite();
			} else {
				navBackground.setTransparant();
			}
		}
		//setNavPosition();
		$(window).on( "scroll mouseenter", function(){
			//setNavPosition();
		});

		// Product slider
		$(".imageSlider").css({ overflow: "hidden" });
		var sliderWidth;
		$(".thumbnails a").each( function (i) {
			$(this).removeClass("zoom").removeAttr("data-rel");
			sliderWidth = $(".imageSlider").width();;
			var href = $(this).attr("href");
			var sliderItem = document.createElement("img");
			$(sliderItem).attr("src", href);
			$(sliderItem).css({ width: sliderWidth });
			$(sliderItem).appendTo(".imageSlider-wrap");
		});
		function setSliderWrapperWidth(){
			var sliderWrapperWidth = $(".thumbnails a").length * $(".imageSlider").width();
			$(".imageSlider-wrap").css({ width: sliderWrapperWidth })
		} 
		setSliderWrapperWidth();
		$(".imageSlider-wrap").css({ transform: "translateX(0px)" });

		$(window).resize( function(){
			sliderWidth = $(".imageSlider").width();
			$(".imageSlider-wrap").css({ transform: "translateX(0px)" });
			setSliderWrapperWidth();  
			$(".imageSlider-wrap img").each( function() {
				$(this).width( sliderWidth );
			})

		})
		
		$(".thumbnails a").click( function (event) {
			event.preventDefault();
			$(".imageSlider-wrap").css({ transform: "translateX(-" + $(this).index() * sliderWidth + "px)" });
		});

		var touchSliderItem = document.querySelector(".imageSlider")
		if (touchSliderItem) {
			touchSliderItem.addEventListener('touchstart', function(e) {
				var touch = e.touches[0],
					currentPos,
					nextPos;

				console.log(touch.pageX);
				var wrapperWidth = $(".imageSlider").width();
				//var currentPosition = matrix[4];
				var wrapper = document.querySelector(".imageSlider-wrap"); 

				console.log(wrapper);

				currentPos = wrapper.style.webkitTransform.split("(")[1].split("p")[0];

				if ( touch.pageX < 120 && currentPos < 0) {
					nextPos = parseInt(currentPos) + parseInt(wrapperWidth);
					wrapper.style.transform = 'translateX(' + nextPos + 'px)';
					wrapper.style.webkitTransform = 'translateX(' + nextPos + 'px)';
				} else if ( touch.pageX > 250 && currentPos > -wrapper.offsetWidth + wrapperWidth) {
					nextPos = currentPos - wrapperWidth;
					wrapper.style.transform = 'translateX(' + nextPos + 'px)';
					wrapper.style.webkitTransform = 'translateX(' + nextPos + 'px)';	
				}
				if ( touch.pageX < 120  ) {
					console.log("left");
				} else if ( touch.pageX > 250  ) {
					console.log("right");
				}
			})
			
		}
		
		// Cart nav
		function resizeCartContent() {
			$(".cart-contents-items").css({ maxHeight : getWindowDimen.getWindowHi() - 89 + "px"});
		}
		$(document).on( "click", ".cart-contents", function(event){
			event.preventDefault();
			$(".cart-contents-items").slideToggle();
			$("#container").toggleClass("noevents");
			//$("footer").toggle();
			resizeCartContent();

		});
		$(window).resize( function(){
			resizeCartContent();
			setMobileNavigation();
		});

		// filter aditional 
		$(".filter-button").on("click", function () {
			$(this).toggleClass("active");
			$(".sidebar-widget").slideToggle();
			$("footer").toggle();
		});
		
		// primary nav
		
		function setMobileNavigation(){
			if ( getWindowDimen.getWindowWi() < 992 ) {
				$(".primary-nav").addClass("mobile");
				$(".burger").css({ display: "block" });			
			} else {
				$(".primary-nav").removeClass("mobile");
				$(".burger").css({ display: "none" });
			}
		}
		setMobileNavigation();

		$(".burger").on("click", function () {
			$(this).toggleClass("active");
			$(".secondary-nav").toggleClass("active");
			$("#container, main").toggleClass("noevents");
			$(".wrapper").toggleClass("active");
		});
		
		function setCategoryHeight(){
			$(".category-item-img-wrap").css({ height : getWindowDimen.getWindowHi() - 138 + "px"});
		}
		setCategoryHeight();

		function setWindowMinHeight(){
			if ( $(".home").length > 0 ) {
				$("main article").css({ height : getWindowDimen.getWindowHi() + "px" });
			} else {
				$("main").css({ minHeight : getWindowDimen.getWindowHi() - $('footer').outerHeight() + "px" });
			}
			
		}
		setWindowMinHeight();
		
		$(window).resize( function(){
			setCategoryHeight();
			setWindowMinHeight(); 
		});
		$("body").css({ overflowX: "hidden" });
		if ( $(".post-100 , .post-106").children(".vc_row-fluid").length > 0 ) {
			$(".post-100 , .post-106").children(".vc_row-fluid").first().css({ width: "150%", margin: "0 0 0 -25%" }).find(".wpb_column").css({ padding: "0" }); 
		}

		// filter button
		function translateSomeExtra(){
			var lang = $("html").attr("lang");
			var btn = $(".filter-button__text");
			var addToCard = $(".add_to_cart_button");
			var toCartButton = $(".toCartButton a");
			//var soldOut = $(".soldout");
			if (lang === "ru-RU") {
				btn.html("Фильтр");
				//addToCard.html("Просмотреть");
				toCartButton.html("Оформить");
			}
			if (lang === "us-EN") {
				btn.html("Filter");
				toCartButton.html("To Card");
				//addToCard.html("View");
				//soldOut.html("Sold Out");
			}
			if (lang === "uk") {
				btn.html("Фільтр");
				//addToCard.html("Просмотреть");
				toCartButton.html("Оформити");
			}
		}
		translateSomeExtra();

		var mapLayout = document.createElement("div"),
			mapPage = $(".page.contacts"); 
		$(mapLayout).attr("id", "map")
		$(mapPage).find(".wrapper").append(mapLayout); 

		// shearch
		$(".secondary-nav-search").click(function(){
			$(".woocommerce-product-search").addClass("active");
		})
		$("button.close").click(function(event){
			event.preventDefault(); 
			$(".woocommerce-product-search").removeClass("active"); 
		})

		//info page
		function getQueryVariable(variable) {
		  var query = window.location.search.substring(1);
		  var vars = query.split("&");
		  for (var i=0;i<vars.length;i++) {
		    var pair = vars[i].split("=");
		    if (pair[0] == variable) {
		      return pair[1];
		    }
		  } 
		  return "";
		}

		function expandBlock() {
			var param = getQueryVariable("block");
			if (param) {
				var item = $("."+param.toString());
				if ($(item).length) {
					setTimeout(function() {
						$(item).find(".vc_toggle_title").trigger('click');
						$('html, body').animate({
					        scrollTop: $(item).offset().top - 100
					    }, 500);
					},1)
					
				}
			}
		}

		 $('.imageSlider-wrap img')
		    .wrap('<span style="display:inline-block" class="zoom-img"></span>')
		    .css('display', 'block')
		    .parent()
		    .zoom({
		    	magnify: 1
		    });

		expandBlock();

		$(".mobile .menu-item a").click(function() {
			if ($(this).next().hasClass('sub-menu')) {
				$(this).next().slideToggle();
				return false;
			}
		});

		$('#owl').owlCarousel({
			items: 1,
			singleItem: true,
			//autoPlay: true,
			navigation: true,
			pagination: false,
			navigationText: ["<i class='slider-left'>","<i class='slider-right'>"],
			slideSpeed: 1000
		});


		
	});
	
})(jQuery, this);


