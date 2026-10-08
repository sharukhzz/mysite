(function () {
	'use strict';

	var header = document.getElementById( 'site-header' );
	var toggle = document.getElementById( 'navToggle' );
	var mobileMenu = document.getElementById( 'mobileMenu' );

	if ( toggle && mobileMenu ) {
		toggle.addEventListener( 'click', function () {
			var isOpen = mobileMenu.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );

		mobileMenu.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', function () {
				mobileMenu.classList.remove( 'is-open' );
				toggle.setAttribute( 'aria-expanded', 'false' );
			} );
		} );
	}

	var heroImg = document.querySelector( '.hero__media img' );
	var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	if ( header || ( heroImg && ! reduceMotion ) ) {
		var ticking = false;
		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) {
				window.requestAnimationFrame( function () {
					if ( header ) {
						header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
					}
					if ( heroImg && ! reduceMotion ) {
						var offset = Math.min( window.scrollY * 0.18, 90 );
						heroImg.style.transform = 'translateY(' + offset + 'px) scale(1.04)';
					}
					ticking = false;
				} );
				ticking = true;
			}
		}, { passive: true } );
	}

	document.querySelectorAll( '.stagger' ).forEach( function ( group ) {
		Array.prototype.forEach.call( group.children, function ( child, i ) {
			child.classList.add( 'reveal' );
			child.style.setProperty( '--stagger-i', i );
		} );
	} );

	var revealTargets = document.querySelectorAll( '.reveal' );
	if ( 'IntersectionObserver' in window && revealTargets.length && ! reduceMotion ) {
		var revealObserver = new IntersectionObserver( function ( entries, obs ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					obs.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' } );

		revealTargets.forEach( function ( el ) {
			revealObserver.observe( el );
		} );
	} else {
		revealTargets.forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
	}

	/**
	 * Services page: auto-advance image sliders.
	 */
	document.querySelectorAll( '.service-slider' ).forEach( function ( slider ) {
		var slides = slider.querySelectorAll( '.service-slider__slide' );
		var dots = slider.querySelectorAll( '.service-slider__dot' );
		if ( slides.length < 2 ) {
			return;
		}

		var index = 0;
		var interval = parseInt( slider.getAttribute( 'data-interval' ), 10 ) || 4000;
		var timer = null;

		function goTo( next ) {
			slides[ index ].classList.remove( 'is-active' );
			if ( dots[ index ] ) {
				dots[ index ].classList.remove( 'is-active' );
			}
			index = ( next + slides.length ) % slides.length;
			slides[ index ].classList.add( 'is-active' );
			if ( dots[ index ] ) {
				dots[ index ].classList.add( 'is-active' );
			}
		}

		function start() {
			if ( reduceMotion ) {
				return;
			}
			stop();
			timer = window.setInterval( function () {
				goTo( index + 1 );
			}, interval );
		}

		function stop() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
		}

		dots.forEach( function ( dot ) {
			dot.addEventListener( 'click', function () {
				var target = parseInt( dot.getAttribute( 'data-index' ), 10 );
				if ( ! isNaN( target ) ) {
					goTo( target );
					start();
				}
			} );
		} );

		slider.addEventListener( 'mouseenter', stop );
		slider.addEventListener( 'mouseleave', start );
		start();
	} );

})();
