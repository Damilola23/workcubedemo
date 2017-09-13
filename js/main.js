
jQuery(function($) {

	//Initiat WOW JS
	new WOW().init();

    // one page navigation 
    $('.main-navigation').onePageNav({
            currentClass: 'active'
    });

    // Countdown
	$('#counter').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
		if (visible) {
			$(this).find('.timer').each(function () {
				var $this = $(this);
				$({ Counter: 0 }).animate({ Counter: $this.text() }, {
					duration: 2000,
					easing: 'swing',
					step: function () {
						$this.text(Math.ceil(this.Counter));
					}
				});
			});
			$(this).unbind('inview');
		}
	});


/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
(function() {

	var bodyEl = document.body,
		content = document.querySelector( '.contents' ),
		openbtn = document.getElementById( 'open-button' ),
		closebtn = document.getElementById( 'close-button' ),
		isOpen = false;

	function init() {
		initEvents();
	}

	function initEvents() {
		openbtn.addEventListener( 'click', toggleMenu );
		if( closebtn ) {
			closebtn.addEventListener( 'click', toggleMenu );
		}

		// close the menu element if the target it´s not the menu element or one of its descendants..
		content.addEventListener( 'click', function(ev) {
			var target = ev.target;
			if( isOpen && target !== openbtn ) {
				toggleMenu();
			}
		} );
	}

	function toggleMenu() {
		if( isOpen ) {
			classie.remove( bodyEl, 'show-menu' );
		}
		else {
			classie.add( bodyEl, 'show-menu' );
		}
		isOpen = !isOpen;
	}

	init();

})();

});



$('#myCarousel').carousel({
  interval: 4000
});

// $('.carousel .item.custom').each(function(){
//   var next = $(this).next();
//   if (!next.length) {
//     next = $(this).siblings(':first');
//   }
//   next.children(':first-child').clone().appendTo($(this));

//   if (next.next().length>0) {
 
//       next.next().children(':first-child').clone().appendTo($(this)).addClass('rightest');
      
//   }
//   else {
//       $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
     
//   }
// });


// custom slider

$(document).ready(function () {
	var itemsMainDiv = ('.MultiCarousel');
	var itemsDiv = ('.MultiCarousel-inner');
	var itemWidth = "";

	$('.leftLst, .rightLst').click(function () {
			var condition = $(this).hasClass("leftLst");
			if (condition)
					click(0, this);
			else
					click(1, this)
	});

	ResCarouselSize();




	$(window).resize(function () {
			ResCarouselSize();
	});

	//this function define the size of the items
	function ResCarouselSize() {
			var incno = 0;
			var dataItems = ("data-items");
			var itemClass = ('.item');
			var id = 0;
			var btnParentSb = '';
			var itemsSplit = '';
			var sampwidth = $(itemsMainDiv).width();
			var bodyWidth = $('body').width();
			$(itemsDiv).each(function () {
					id = id + 1;
					var itemNumbers = $(this).find(itemClass).length;
					btnParentSb = $(this).parent().attr(dataItems);
					itemsSplit = btnParentSb.split(',');
					$(this).parent().attr("id", "MultiCarousel" + id);


					if (bodyWidth >= 1200) {
							incno = itemsSplit[3];
							itemWidth = sampwidth / incno;
					}
					else if (bodyWidth >= 992) {
							incno = itemsSplit[2];
							itemWidth = sampwidth / incno;
					}
					else if (bodyWidth >= 768) {
							incno = itemsSplit[1];
							itemWidth = sampwidth / incno;
					}
					else {
							incno = itemsSplit[0];
							itemWidth = sampwidth / incno;
					}
					$(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
					$(this).find(itemClass).each(function () {
							$(this).outerWidth(itemWidth);
					});

					$(".leftLst").addClass("over");
					$(".rightLst").removeClass("over");

			});
	}


	//this function used to move the items
	function ResCarousel(e, el, s) {
			var leftBtn = ('.leftLst');
			var rightBtn = ('.rightLst');
			var translateXval = '';
			var divStyle = $(el + ' ' + itemsDiv).css('transform');
			var values = divStyle.match(/-?[\d\.]+/g);
			var xds = Math.abs(values[4]);
			if (e == 0) {
					translateXval = parseInt(xds) - parseInt(itemWidth * s);
					$(el + ' ' + rightBtn).removeClass("over");

					if (translateXval <= itemWidth / 2) {
							translateXval = 0;
							$(el + ' ' + leftBtn).addClass("over");
					}
			}
			else if (e == 1) {
					var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
					translateXval = parseInt(xds) + parseInt(itemWidth * s);
					$(el + ' ' + leftBtn).removeClass("over");

					if (translateXval >= itemsCondition - itemWidth / 2) {
							translateXval = itemsCondition;
							$(el + ' ' + rightBtn).addClass("over");
					}
			}
			$(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
	}

	//It is used to get some elements from btn
	function click(ell, ee) {
			var Parent = "#" + $(ee).parent().attr("id");
			var slide = $(Parent).attr("data-slide");
			ResCarousel(ell, Parent, slide);
	}

});