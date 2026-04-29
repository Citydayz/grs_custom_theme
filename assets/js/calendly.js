/**
 * CBS Theme — initialisation des widgets Calendly inline
 */
(function () {
	'use strict';

	var tries = 0;
	var maxTries = 60;

	function initCalendlyInline() {
		if ( typeof window.Calendly === 'undefined' || typeof window.Calendly.initInlineWidget !== 'function' ) {
			return false;
		}

		document.querySelectorAll( '.calendly-inline-widget[data-url]' ).forEach( function ( el ) {
			if ( el.querySelector( 'iframe' ) ) {
				return;
			}
			var url = el.getAttribute( 'data-url' );
			if ( ! url ) {
				return;
			}
			window.Calendly.initInlineWidget( {
				url: url,
				parentElement: el,
			} );
		} );
		return true;
	}

	function scheduleInit() {
		if ( initCalendlyInline() ) {
			return;
		}
		var id = window.setInterval( function () {
			tries += 1;
			if ( initCalendlyInline() || tries >= maxTries ) {
				window.clearInterval( id );
			}
		}, 100 );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', scheduleInit );
	} else {
		scheduleInit();
	}
})();
