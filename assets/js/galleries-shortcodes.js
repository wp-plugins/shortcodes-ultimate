jQuery(document).ready(function ($) {
	// Enable sliders
	$('.su-slider').each(function () {
		// Prepare data
		var $slider = $(this);
		// Apply Swiper
		var $swiper = $slider.swiper({
			wrapperClass: 'su-slider-slides',
			slideClass: 'su-slider-slide',
			slideActiveClass: 'su-slider-slide-active',
			slideVisibleClass: 'su-slider-slide-visible',
			pagination: '#' + $slider.attr('id') + ' .su-slider-pagination',
			autoplay: $slider.data('autoplay'),
			paginationClickable: true,
			grabCursor: true,
			mode: 'horizontal',
			mousewheelControl: $slider.data('mousewheel'),
			speed: $slider.data('speed'),
			calculateHeight: $slider.hasClass('su-slider-responsive-yes'),
			loop: true
		});
		// Prev button
		$slider.find('.su-slider-prev').click(function (e) {
			$swiper.swipeNext();
		});
		// Next button
		$slider.find('.su-slider-next').click(function (e) {
			$swiper.swipePrev();
		});
	});
	// Enable carousels
	$('.su-carousel').each(function () {
		// Prepare data
		var $carousel = $(this),
			$slides = $carousel.find('.su-carousel-slide');
		// Apply Swiper
		var $swiper = $carousel.swiper({
			wrapperClass: 'su-carousel-slides',
			slideClass: 'su-carousel-slide',
			slideActiveClass: 'su-carousel-slide-active',
			slideVisibleClass: 'su-carousel-slide-visible',
			pagination: '#' + $carousel.attr('id') + ' .su-carousel-pagination',
			autoplay: $carousel.data('autoplay'),
			paginationClickable: true,
			grabCursor: true,
			mode: 'horizontal',
			mousewheelControl: $carousel.data('mousewheel'),
			speed: $carousel.data('speed'),
			slidesPerView: ($carousel.data('items') > $slides.length) ? $slides.length : $carousel.data('items'),
			slidesPerGroup: $carousel.data('scroll'),
			calculateHeight: $carousel.hasClass('su-carousel-responsive-yes'),
			loop: true
		});
		// Prev button
		$carousel.find('.su-carousel-prev').click(function (e) {
			$swiper.swipeNext();
		});
		// Next button
		$carousel.find('.su-carousel-next').click(function (e) {
			$swiper.swipePrev();
		});
	});
});