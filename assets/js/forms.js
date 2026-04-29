/**
 * CBS Theme — validation et envoi AJAX formulaire contact (forms.md §4).
 */
(function () {
	'use strict';

	const CONTACT_ACTION = 'cbs_contact_form';
	const FETCH_TIMEOUT_MS = 15000;

	/**
	 * @param {string} url
	 * @param {RequestInit} options
	 * @param {number} ms
	 * @returns {Promise<Response>}
	 */
	function fetchWithTimeout( url, options, ms ) {
		const controller = new AbortController();
		const timer = window.setTimeout( function () {
			controller.abort();
		}, ms );
		return fetch( url, Object.assign( {}, options, { signal: controller.signal } ) ).finally( function () {
			window.clearTimeout( timer );
		} );
	}

	/**
	 * @param {HTMLElement} input
	 * @returns {boolean}
	 */
	function validerChamp( input ) {
		const errorEl = document.getElementById( input.id + '-error' );
		let message = '';

		if ( input.type === 'checkbox' ) {
			if ( input.required && ! input.checked ) {
				message = 'Vous devez accepter le traitement des données.';
			}
		} else if ( input.tagName === 'SELECT' ) {
			if ( input.required && ( ! input.value || input.value === '' ) ) {
				message = 'Ce champ est obligatoire.';
			}
		} else {
			if ( input.required && ! input.value.trim() ) {
				message = 'Ce champ est obligatoire.';
			} else if ( input.type === 'email' && input.value && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( input.value ) ) {
				message = 'Veuillez entrer une adresse email valide.';
			} else if ( input.type === 'tel' && input.value && ! /^[\d\s+.()-]{8,}$/.test( input.value ) ) {
				message = 'Numéro de téléphone invalide.';
			}
		}

		if ( message ) {
			input.classList.add( 'is-invalid' );
			input.classList.remove( 'is-valid' );
			input.setAttribute( 'aria-invalid', 'true' );
			if ( errorEl ) {
				errorEl.textContent = message;
				errorEl.removeAttribute( 'hidden' );
			}
			return false;
		}

		input.classList.remove( 'is-invalid' );
		input.classList.add( 'is-valid' );
		input.setAttribute( 'aria-invalid', 'false' );
		if ( errorEl ) {
			errorEl.textContent = '';
			errorEl.setAttribute( 'hidden', '' );
		}
		return true;
	}

	/**
	 * @param {HTMLFormElement} formEl
	 * @returns {boolean}
	 */
	function validerTout( formEl ) {
		let ok = true;
		const champs = formEl.querySelectorAll( '.form__input, .form__select, .form__textarea' );
		champs.forEach( function ( el ) {
			if ( ! validerChamp( el ) ) {
				ok = false;
			}
		} );
		const rgpd = formEl.querySelector( '#cbs-rgpd' );
		if ( rgpd && ! validerChamp( rgpd ) ) {
			ok = false;
		}
		return ok;
	}

	/**
	 * @param {HTMLFormElement} formEl
	 */
	function initFormValidation( formEl ) {
		const champs = formEl.querySelectorAll( '.form__input, .form__select, .form__textarea' );
		champs.forEach( function ( input ) {
			input.addEventListener( 'blur', function () {
				validerChamp( input );
			} );
			input.addEventListener( 'input', function () {
				if ( input.classList.contains( 'is-invalid' ) ) {
					validerChamp( input );
				}
			} );
			input.addEventListener( 'change', function () {
				if ( input.classList.contains( 'is-invalid' ) || input.tagName === 'SELECT' ) {
					validerChamp( input );
				}
			} );
		} );
		const rgpd = formEl.querySelector( '#cbs-rgpd' );
		if ( rgpd ) {
			rgpd.addEventListener( 'change', function () {
				if ( rgpd.classList.contains( 'is-invalid' ) ) {
					validerChamp( rgpd );
				}
			} );
		}
	}

	/**
	 * @param {HTMLFormElement} formEl
	 * @param {HTMLElement|null} feedbackEl
	 * @param {string} [message]
	 */
	function afficherSucces( formEl, feedbackEl, message ) {
		const msg =
			message ||
			'Votre message a bien été envoyé. Nous vous répondrons sous 24h.';
		formEl.reset();
		formEl.querySelectorAll( '.is-valid, .is-invalid' ).forEach( function ( el ) {
			el.classList.remove( 'is-valid', 'is-invalid' );
			el.setAttribute( 'aria-invalid', 'false' );
		} );
		if ( feedbackEl ) {
			feedbackEl.textContent = msg;
			feedbackEl.className = 'form__feedback form__feedback--success';
			feedbackEl.removeAttribute( 'hidden' );
			feedbackEl.setAttribute( 'tabindex', '-1' );
			feedbackEl.focus();
		}
	}

	/**
	 * @param {HTMLElement|null} feedbackEl
	 * @param {string} message
	 */
	function afficherErreurFormulaire( feedbackEl, message ) {
		if ( feedbackEl ) {
			feedbackEl.textContent = message;
			feedbackEl.className = 'form__feedback form__feedback--error';
			feedbackEl.removeAttribute( 'hidden' );
			feedbackEl.setAttribute( 'tabindex', '-1' );
			feedbackEl.focus();
		}
	}

	/**
	 * @param {HTMLFormElement} formEl
	 * @returns {Promise<void>}
	 */
	async function soumettreFormulaire( formEl ) {
		if ( formEl.dataset.submitting === 'true' ) {
			return;
		}
		
		// Create FormData BEFORE disabling inputs, otherwise they won't be serialized
		const formData = new FormData( formEl );
		formData.append( 'action', CONTACT_ACTION );
		if ( window.cbsContactAjax && window.cbsContactAjax.nonce ) {
			formData.set( 'cbs_nonce', window.cbsContactAjax.nonce );
		}

		formEl.dataset.submitting = 'true';

		const submitBtn = formEl.querySelector( '.form__submit' );
		const feedback = formEl.querySelector( '.form__feedback' );
		const labelOriginal = submitBtn ? submitBtn.textContent : '';

		formEl.querySelectorAll( 'input, select, textarea, button' ).forEach( function ( el ) {
			el.disabled = true;
		} );
		if ( submitBtn ) {
			submitBtn.textContent = 'Envoi en cours…';
		}

		try {
			if ( typeof window.cbsContactAjax === 'undefined' || ! window.cbsContactAjax.url ) {
				throw new Error( 'missing_ajax' );
			}

			const response = await fetchWithTimeout(
				window.cbsContactAjax.url,
				{
					method: 'POST',
					body: formData,
					credentials: 'same-origin',
				},
				FETCH_TIMEOUT_MS
			);

			let data = null;
			try {
				data = await response.json();
			} catch ( e ) {
				data = null;
			}

			if ( data && data.success ) {
				afficherSucces( formEl, feedback, data.data && data.data.message ? data.data.message : undefined );
			} else if ( data && data.data && data.data.message ) {
				afficherErreurFormulaire( feedback, data.data.message );
			} else {
				afficherErreurFormulaire(
					feedback,
					'Une erreur est survenue. Réessayez.'
				);
			}
		} catch ( error ) {
			const message = ! navigator.onLine
				? 'Vérifiez votre connexion internet.'
				: 'Une erreur est survenue. Réessayez dans quelques instants.';
			afficherErreurFormulaire( feedback, message );
		} finally {
			formEl.dataset.submitting = 'false';
			formEl.querySelectorAll( 'input, select, textarea, button' ).forEach( function ( el ) {
				el.disabled = false;
			} );
			if ( submitBtn ) {
				submitBtn.textContent = labelOriginal || 'Envoyer ma demande';
			}
		}
	}

	function init() {
		const form = document.getElementById( 'form-contact' );
		if ( ! form || ! ( form instanceof HTMLFormElement ) ) {
			return;
		}

		initFormValidation( form );

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			if ( ! validerTout( form ) ) {
				return;
			}
			soumettreFormulaire( form );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
})();
