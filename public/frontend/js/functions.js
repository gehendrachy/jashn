$(document).scroll(function() {
	var y = $(this).scrollTop();
	if (y > 600) {
		$('#header-Nav').addClass("sticky-nav");
	} 
	else{
		$('#header-Nav').removeClass("sticky-nav");
	}
});
$(document).ready(function(){
    var width = $(window).width(); 
    var height = $(window).height(); 

    if (( width > 1025  )) {
     //do something
     var s = ".menu-level-one";
        $(".menu > li").mouseenter(function(){
        	$(this).find('>'+s).addClass("show");
        });
        $(".sub-level-one > li").mouseenter(function(){
        	$(this).find('>'+s).addClass("show");
        });
        $(".menu > li").mouseleave(function(){
        	$(this).find('>'+s).removeClass("show");
        });
        $(".sub-level-one > li").mouseleave(function(){
        	$(this).find('>'+s).removeClass("show");
        });
        $(".sub-level-two > li").mouseenter(function(){
        	$(this).find(".menu-level-three").addClass("show");
        });
        $(".sub-level-two > li").mouseleave(function(){
        	$(this).find(".menu-level-three").removeClass("show");
        });
    }
    else {
    //do something else
    }
})


// $(".mobile-main-menu").click(function(e){
// 	e.preventDefault();
// 	$(this).parent().find(".mobile-menu-level-one").slideToggle();
// });
// $(".mobile-sub-level-one .has-sub").click(function(e){
// 	e.preventDefault();
// 	$(this).parent().find(".mobile-menu-level-two").slideToggle();
// });
// $(".mobile-sub-level-two .has-sub").click(function(e){
// 	e.preventDefault();
// 	$(this).parent().find(".mobile-menu-level-three").slideToggle();
// })
// $(".mobile-sub-level-three .has-sub").click(function(e){
// 	e.preventDefault();
// 	$(this).parent().find(".mobile-menu-level-four").slideToggle();
// })

$("#grid-view").click(function(e){
	e.preventDefault();
	$(".product-bootstrap").addClass("col-lg-4");
	$(".product-bootstrap").removeClass("col-lg-6");
	$(".product-bootstrap").removeClass("list-view");
	$(".product-bootstrap .product").addClass("jqueryEqualHeight");
	$("#seeMoreBtn").attr('data-layout','grid-view');
});
$("#list-view").click(function(e){
	e.preventDefault();
	$(".product-bootstrap").addClass("col-lg-6");
	$(".product-bootstrap").removeClass("col-lg-4");
	$(".product-bootstrap").addClass("list-view");
	$(".product-bootstrap .product").removeClass("jqueryEqualHeight");
	$("#seeMoreBtn").attr('data-layout','list-view');
})

$( window ).resize(function() {
	if ($(window).width() < 1025) {
		$( ".menu" ).addClass("for-flow");
	}
});
$(".filter-button a").click(function(e){
	e.preventDefault();
	$("body").addClass("filter-shown");
	$(".filter-wrapper").addClass("visible");
});
$(".filter-close").click(function(e){
	e.preventDefault();
	$("body").removeClass("filter-shown");
	$(".filter-wrapper").removeClass("visible");
})


var swiper = new Swiper('.swiper1', {
	pagination: {
		el: '.swiper-pagination',
		clickable:true
	},
	autoHeight: true,
	autoplay: {
		delay: 2700,
		disableOnInteraction: false,
	},
	effect: "creative",
	creativeEffect: {
		prev: {
			shadow: true,
			translate: [0, 0, -400],
		},
		next: {
			translate: ["100%", 0, 0],
		},
	},
});
var swiperThumbs = new Swiper(".swiper-thumbs", {
	spaceBetween: 5,
	slidesPerView: 4,
	freeMode: false,
	watchSlidesVisibility: true,
	watchSlidesProgress: true,
	// centeredSlides: true,
});
var swiper = new Swiper('.swiper-main', {
	autoHeight: true,
	effect: "fade",
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	thumbs: {
		swiper: swiperThumbs,
	},
});
var swiper = new Swiper(".swiper-category", {
	slidesPerView: 5.5,
	spaceBetween: 20,
	loop:false,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	breakpoints: {
		640: {
			slidesPerView: 5.5,
			spaceBetween: 20,
		},
		768: {
			slidesPerView: 8.5,
			spaceBetween: 40,
		},
		1024: {
			slidesPerView: 5.5,
			spaceBetween: 50,
		},
	},
});
var swiper = new Swiper(".related-products-swiper", {
	loop:false,
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	breakpoints: {
		0:{
			slidesPerView: 2,
			spaceBetween: 2,
		},
		640: {
			slidesPerView: 2,
			spaceBetween: 2,
		},
		768: {
			slidesPerView: 3,
			spaceBetween: 4,
		},
		1024: {
			slidesPerView: 4.5  ,
			spaceBetween: 5,
		},
	},
});

$(window).on('load', function(event) {
	$('.jQueryEqualHeight').jQueryEqualHeight('.product-details .seen-product-details');
	$('.jQueryEqualHeight').jQueryEqualHeight('.product-details');
	$('.jQueryEqualHeightChanging').jQueryEqualHeight('.product-details .seen-product-details');
	$('.jQueryEqualHeightChanging').jQueryEqualHeight('.product-details');
});

function myFunction() {
	document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
	if (!event.target.matches('.dropbtn')) {
		var dropdowns = document.getElementsByClassName("dropdown-content");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
			var openDropdown = dropdowns[i];
			if (openDropdown.classList.contains('show')) {
				openDropdown.classList.remove('show');
			}
		}
	}
}

/////////////////// product +/-
// $(document).ready(function() {
// 	$('.num-in span').click(function () {
// 		var $input = $(this).parents('.num-block').find('input.in-num');
// 		if($(this).hasClass('minus')) {
// 			var count = parseFloat($input.val()) - 1;
// 			count = count < 1 ? 1 : count;
// 			if (count < 2) {
// 				$(this).addClass('dis');
// 			}
// 			else {
// 				$(this).removeClass('dis');
// 			}
// 			$input.val(count);
// 		}
// 		else {
// 			var count = parseFloat($input.val()) + 1
// 			$input.val(count);
// 			if (count > 1) {
// 				$(this).parents('.num-block').find(('.minus')).removeClass('dis');
// 			}
// 		}
		
// 		$input.change();
// 		return false;
// 	});
	
// });
// product +/-


$(document).ready(function() { 
	
	(function ($) { 
		$('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
		
		$('.tab ul.tabs li a').click(function (g) { 
			var tab = $(this).closest('.tab'), 
			index = $(this).closest('li').index();
			
			tab.find('ul.tabs > li').removeClass('current');
			$(this).closest('li').addClass('current');
			
			tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
			tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
			
			g.preventDefault();
		} );
	})(jQuery);
	
});

$(".payment-radio label").click(function(){
	$(".pay-details").hide();
	$(this).parent().siblings().show();
});

$("#is-logged-in .nav-button").click(function(e){
	e.preventDefault();
});

$(".cart-wrapper").click(function(e){
	e.preventDefault();
	$("#cart").addClass("show");
	$("body").addClass("cart-show")
});

$("#cart-close").click(function(){
	$("#cart").removeClass("show");
	$("body").removeClass("cart-show")
});

$(".question").click(function(){
	$(".answer").slideUp();
	$(this).siblings().slideToggle();
});

$("#faq-links li a").click(function(e){
	$("#faq-links li a").removeClass("active");
	e.preventDefault();
	$(this).addClass("active")
	var iD = $(this).attr("id");
	$(".faq-wrapper").hide();
	$('.faq-wrapper[data-id="' + iD + '"').toggle();
})

// Comparison Table JS

jQuery(document).ready(function($){
	function productsTable( element ) {
		this.element = element;
		this.table = this.element.children('.cd-products-table');
		this.tableHeight = this.table.height();
		this.productsWrapper = this.table.children('.cd-products-wrapper');
		this.tableColumns = this.productsWrapper.children('.cd-products-columns');
		this.products = this.tableColumns.children('.product');
		this.productsNumber = this.products.length;
		this.productWidth = this.products.eq(0).width();
		this.productsTopInfo = this.table.find('.top-info');
		this.featuresTopInfo = this.table.children('.features').children('.top-info');
		this.topInfoHeight = this.featuresTopInfo.innerHeight() + 30;
		this.leftScrolling = false;
		this.filterBtn = this.element.find('.filter');
		this.resetBtn = this.element.find('.reset');
		this.filtering = false,
		this.selectedproductsNumber = 0;
		this.filterActive = false;
		this.navigation = this.table.children('.cd-table-navigation');
		// bind table events
		this.bindEvents();
	}
	
	productsTable.prototype.bindEvents = function() {
		var self = this;
		//detect scroll left inside producst table
		self.productsWrapper.on('scroll', function(){
			if(!self.leftScrolling) {
				self.leftScrolling = true;
				(!window.requestAnimationFrame) ? setTimeout(function(){self.updateLeftScrolling();}, 250) : window.requestAnimationFrame(function(){self.updateLeftScrolling();});
			}
		});
		//select single product to filter
		self.products.on('click', '.top-info', function(){
			var product = $(this).parents('.product');
			if( !self.filtering && product.hasClass('selected') ) {
				product.removeClass('selected');
				self.selectedproductsNumber = self.selectedproductsNumber - 1;
				self.upadteFilterBtn();
			} else if( !self.filtering && !product.hasClass('selected') ) {
				product.addClass('selected');
				self.selectedproductsNumber = self.selectedproductsNumber + 1;
				self.upadteFilterBtn();
			}
		});
		//filter products
		self.filterBtn.on('click', function(event){
			event.preventDefault();
			if(self.filterActive) {
				self.filtering =  true;
				self.showSelection();
				self.filterActive = false;
				self.filterBtn.removeClass('active');
			}
		});
		//reset product selection
		self.resetBtn.on('click', function(event){
			event.preventDefault();
			if( self.filtering ) {
				self.filtering =  false;
				self.resetSelection();
			} else {
				self.products.removeClass('selected');
			}
			self.selectedproductsNumber = 0;
			self.upadteFilterBtn();
		});
		//scroll inside products table
		this.navigation.on('click', 'a', function(event){
			event.preventDefault();
			self.updateSlider( $(event.target).hasClass('next') );
		});
	}
	
	productsTable.prototype.upadteFilterBtn = function() {
		//show/hide filter btn
		if( this.selectedproductsNumber >= 2 ) {
			this.filterActive = true;
			this.filterBtn.addClass('active');
		} else {
			this.filterActive = false;
			this.filterBtn.removeClass('active');
		}
	}
	
	productsTable.prototype.updateLeftScrolling = function() {
		var totalTableWidth = parseInt(this.tableColumns.eq(0).outerWidth(true)),
		tableViewport = parseInt(this.element.width()),
		scrollLeft = this.productsWrapper.scrollLeft();
		
		( scrollLeft > 0 ) ? this.table.addClass('scrolling') : this.table.removeClass('scrolling');
		
		if( this.table.hasClass('top-fixed') && checkMQ() == 'desktop') {
			setTranformX(this.productsTopInfo, '-'+scrollLeft);
			setTranformX(this.featuresTopInfo, '0');
		}
		
		this.leftScrolling =  false;
		
		this.updateNavigationVisibility(scrollLeft);
	}
	
	productsTable.prototype.updateNavigationVisibility = function(scrollLeft) {
		( scrollLeft > 0 ) ? this.navigation.find('.prev').removeClass('inactive') : this.navigation.find('.prev').addClass('inactive');
		( scrollLeft < this.tableColumns.outerWidth(true) - this.productsWrapper.width() && this.tableColumns.outerWidth(true) > this.productsWrapper.width() ) ? this.navigation.find('.next').removeClass('inactive') : this.navigation.find('.next').addClass('inactive');
	}
	
	productsTable.prototype.updateTopScrolling = function(scrollTop) {
		var offsetTop = this.table.offset().top,
		tableScrollLeft = this.productsWrapper.scrollLeft();
		
		if ( offsetTop <= scrollTop && offsetTop + this.tableHeight - this.topInfoHeight >= scrollTop ) {
			//fix products top-info && arrows navigation
			if( !this.table.hasClass('top-fixed') && $(document).height() > offsetTop + $(window).height() + 200) { 
				this.table.addClass('top-fixed').removeClass('top-scrolling');
				if( checkMQ() == 'desktop' ) {
					this.productsTopInfo.css('top', '0');
					this.navigation.find('a').css('top', '0px');
				}
			}
			
		} else if( offsetTop <= scrollTop ) {
			//product top-info && arrows navigation -  scroll with table
			this.table.removeClass('top-fixed').addClass('top-scrolling');
			if( checkMQ() == 'desktop' )  {
				this.productsTopInfo.css('top', (this.tableHeight - this.topInfoHeight) +'px');
				this.navigation.find('a').css('top', (this.tableHeight - this.topInfoHeight) +'px');
			}
		} else {
			//product top-info && arrows navigation -  reset style
			this.table.removeClass('top-fixed top-scrolling');
			this.productsTopInfo.attr('style', '');
			this.navigation.find('a').attr('style', '');
		}
		
		this.updateLeftScrolling();
	}
	
	productsTable.prototype.updateProperties = function() {
		this.tableHeight = this.table.height();
		this.productWidth = this.products.eq(0).width();
		this.topInfoHeight = this.featuresTopInfo.innerHeight() + 30;
		this.tableColumns.css('width', this.productWidth*this.productsNumber + 'px');
	}
	
	productsTable.prototype.showSelection = function() {
		this.element.addClass('filtering');
		this.filterProducts();
	}
	
	productsTable.prototype.resetSelection = function() {
		this.tableColumns.css('width', this.productWidth*this.productsNumber + 'px');
		this.element.removeClass('no-product-transition');
		this.resetProductsVisibility();
	}
	
	productsTable.prototype.filterProducts = function() {
		var self = this,
		containerOffsetLeft = self.tableColumns.offset().left,
		scrollLeft = self.productsWrapper.scrollLeft(),
		selectedProducts = this.products.filter('.selected'),
		numberProducts = selectedProducts.length;
		
		selectedProducts.each(function(index){
			var product = $(this),
			leftTranslate = containerOffsetLeft + index*self.productWidth + scrollLeft - product.offset().left;
			setTranformX(product, leftTranslate);
			
			if(index == numberProducts - 1 ) {
				product.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
					setTimeout(function(){
						self.element.addClass('no-product-transition');
					}, 50);
					setTimeout(function(){
						self.element.addClass('filtered');
						self.productsWrapper.scrollLeft(0);
						self.tableColumns.css('width', self.productWidth*numberProducts + 'px');
						selectedProducts.attr('style', '');
						product.off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
						self.updateNavigationVisibility(0);
					}, 100);
				});
			}
		});
		
		if( $('.no-csstransitions').length > 0 ) {
			//browser not supporting css transitions
			self.element.addClass('filtered');
			self.productsWrapper.scrollLeft(0);
			self.tableColumns.css('width', self.productWidth*numberProducts + 'px');
			selectedProducts.attr('style', '');
			self.updateNavigationVisibility(0);
		}
	}
	
	productsTable.prototype.resetProductsVisibility = function() {
		var self = this,
		containerOffsetLeft = self.tableColumns.offset().left,
		selectedProducts = this.products.filter('.selected'),
		numberProducts = selectedProducts.length,
		scrollLeft = self.productsWrapper.scrollLeft(),
		n = 0;
		
		self.element.addClass('no-product-transition').removeClass('filtered');
		
		self.products.each(function(index){
			var product = $(this);
			if (product.hasClass('selected')) {
				n = n + 1;
				var leftTranslate = (-index + n - 1)*self.productWidth;
				setTranformX(product, leftTranslate);
			}
		});
		
		setTimeout(function(){
			self.element.removeClass('no-product-transition filtering');
			setTranformX(selectedProducts, '0');
			selectedProducts.removeClass('selected').attr('style', '');
		}, 50);
	}
	
	productsTable.prototype.updateSlider = function(bool) {
		var scrollLeft = this.productsWrapper.scrollLeft();
		scrollLeft = ( bool ) ? scrollLeft + this.productWidth : scrollLeft - this.productWidth;
		
		if( scrollLeft < 0 ) scrollLeft = 0;
		if( scrollLeft > this.tableColumns.outerWidth(true) - this.productsWrapper.width() ) scrollLeft = this.tableColumns.outerWidth(true) - this.productsWrapper.width();
		
		this.productsWrapper.animate( {scrollLeft: scrollLeft}, 200 );
	}
	
	var comparisonTables = [];
	$('.cd-products-comparison-table').each(function(){
		//create a productsTable object for each .cd-products-comparison-table
		comparisonTables.push(new productsTable($(this)));
	});
	
	var windowScrolling = false;
	//detect window scroll - fix product top-info on scrolling
	$(window).on('scroll', function(){
		if(!windowScrolling) {
			windowScrolling = true;
			(!window.requestAnimationFrame) ? setTimeout(checkScrolling, 250) : window.requestAnimationFrame(checkScrolling);
		}
	});
	
	var windowResize = false;
	//detect window resize - reset .cd-products-comparison-table properties
	$(window).on('resize', function(){
		if(!windowResize) {
			windowResize = true;
			(!window.requestAnimationFrame) ? setTimeout(checkResize, 250) : window.requestAnimationFrame(checkResize);
		}
	});
	
	function checkScrolling(){
		var scrollTop = $(window).scrollTop();
		comparisonTables.forEach(function(element){
			element.updateTopScrolling(scrollTop);
		});
		
		windowScrolling = false;
	}
	
	function checkResize(){
		comparisonTables.forEach(function(element){
			element.updateProperties();
		});
		
		windowResize = false;
	}
	
	function checkMQ() {
		//check if mobile or desktop device
		return window.getComputedStyle(comparisonTables[0].element.get(0), '::after').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
	}
	
	function setTranformX(element, value) {
		element.css({
			'-moz-transform': 'translateX(' + value + 'px)',
			'-webkit-transform': 'translateX(' + value + 'px)',
			'-ms-transform': 'translateX(' + value + 'px)',
			'-o-transform': 'translateX(' + value + 'px)',
			'transform': 'translateX(' + value + 'px)'
		});
	}
});

  $( function() {
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    $( "#main-search" ).autocomplete({
      source: availableTags,
	//   response: function(event, ui) {
	// 	// ui.content is the array that's about to be sent to the response callback.
	// 	if (ui.content.length === 0) {
	// 		$("#empty-message").text("No results found");
	// 	} else {
	// 		$("#empty-message").empty();
	// 	}
	// }
    });
  } );