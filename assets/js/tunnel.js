/**
 * CBS Theme — tunnel diagnostic multi-étapes (diagnostic-tunnel.md §8, agent-tunnel.md).
 */
( function () {
	'use strict';

	const FETCH_TIMEOUT_MS = 15000;
	const DIAGNOSTIC_ACTION = 'cbs_diagnostic';

	/** @type {'consulting_projet'|'consulting_existant'|'gestion'|null} */
	let userContext = null;

	/** Parcours après la question contexte (sans inclure context). */
	const PATHS = {
		consulting_projet: [ 'o1', 'o2', 'o3', 'o4', 'o5', 'o6', 'o7', 'o8', 'o9', 'o10' ],
		consulting_existant: [ 'o1', 'o2', 'o3', 'o4', 'o5', 'o6', 'o7', 'o8', 'o9', 'o10' ],
		gestion: [ 'o1', 'g1', 'g2', 'g3', 'o6', 'o7', 'o8', 'o9', 'o10' ],
	};

	/** Index d’étape : 0 = contexte, 1..PATH.length = questions. */
	let flowIndex = 0;

	const META_GENERIC_FALLBACK = '3 minutes · 10 questions · Résultat immédiat';
	const META_GESTION_FALLBACK = '2 minutes · 9 questions · Résultat immédiat';

	/** @type {Record<string, number>} clés '1'..'10' — points scoring */
	const reponses = {};

	/** @type {Record<string, string>} champs gestion_salaries, gestion_rh, gestion_gestion */
	const gestionReponses = {};

	let isSubmitting = false;

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
	 * @returns {string}
	 */
	function msgGenericError() {
		if ( typeof cbsAjax !== 'undefined' && cbsAjax.strings && cbsAjax.strings.genericError ) {
			return cbsAjax.strings.genericError;
		}
		return 'Une erreur est survenue. Veuillez réessayer.';
	}

	/**
	 * @returns {string}
	 */
	function msgTimeout() {
		if ( typeof cbsAjax !== 'undefined' && cbsAjax.strings && cbsAjax.strings.timeout ) {
			return cbsAjax.strings.timeout;
		}
		return 'Le serveur met trop longtemps à répondre. Réessayez dans un instant.';
	}

	/**
	 * @returns {string}
	 */
	function msgOffline() {
		if ( typeof cbsAjax !== 'undefined' && cbsAjax.strings && cbsAjax.strings.offline ) {
			return cbsAjax.strings.offline;
		}
		return 'Vérifiez votre connexion internet puis réessayez.';
	}

	/**
	 * @param {HTMLElement} root
	 * @param {string} text
	 */
	function setLiveRegion( root, text ) {
		const live = root.querySelector( '#tunnel-live-region' );
		if ( live ) {
			live.textContent = text;
		}
	}

	/**
	 * @param {HTMLElement} el
	 * @param {boolean} visible
	 */
	function setVisible( el, visible ) {
		if ( ! el ) {
			return;
		}
		el.hidden = ! visible;
		el.setAttribute( 'aria-hidden', visible ? 'false' : 'true' );
	}

	/**
	 * @returns {number|null}
	 */
	function getTotalSteps() {
		if ( ! userContext ) {
			return null;
		}
		return 1 + PATHS[ userContext ].length;
	}

	/**
	 * @param {HTMLElement} root
	 * @returns {string}
	 */
	function getStepsMetaGenericText( root ) {
		const introMeta = root.querySelector( '#tunnel-intro-meta' );
		if ( introMeta && introMeta.textContent.trim() ) {
			return introMeta.textContent.trim();
		}
		return META_GENERIC_FALLBACK;
	}

	/**
	 * Texte sous-titre durée / volume : uniquement #tunnel-steps-meta (intro landing inchangée).
	 *
	 * @param {HTMLElement} root
	 */
	function syncTunnelStepsMeta( root ) {
		const stepsMeta = root.querySelector( '#tunnel-steps-meta' );
		if ( ! stepsMeta ) {
			return;
		}
		const generic = getStepsMetaGenericText( root );
		const gestionStr =
			root.getAttribute( 'data-tunnel-meta-gestion' ) || META_GESTION_FALLBACK;
		if ( ! userContext ) {
			stepsMeta.textContent = generic;
			return;
		}
		if ( userContext === 'gestion' ) {
			stepsMeta.textContent = gestionStr;
			return;
		}
		stepsMeta.textContent = generic;
	}

	/**
	 * @param {HTMLElement} panel
	 */
	function resetRadiosInPanel( panel ) {
		panel.querySelectorAll( '[role="radio"]' ).forEach( function ( btn ) {
			btn.setAttribute( 'aria-checked', 'false' );
			btn.classList.remove( 'is-selected' );
		} );
	}

	/**
	 * @param {string} key
	 * @param {HTMLElement} root
	 */
	function clearAnswerForPathKey( key, root ) {
		if ( key.charAt( 0 ) === 'o' ) {
			const n = key.slice( 1 );
			delete reponses[ n ];
			const panel = root.querySelector( '#tunnel-step-o-' + n );
			if ( panel ) {
				resetRadiosInPanel( panel );
			}
		} else if ( key.charAt( 0 ) === 'g' ) {
			const gi = parseInt( key.slice( 1 ), 10 );
			const fields = [ 'gestion_salaries', 'gestion_rh', 'gestion_gestion' ];
			const field = fields[ gi - 1 ];
			if ( field ) {
				delete gestionReponses[ field ];
			}
			const panel = root.querySelector( '#tunnel-step-g-' + gi );
			if ( panel ) {
				resetRadiosInPanel( panel );
			}
		}
	}

	/**
	 * @param {HTMLElement} root
	 */
	function resetContextRadios( root ) {
		const group = root.querySelector( '#tunnel-context-group' );
		if ( ! group ) {
			return;
		}
		group.querySelectorAll( '[role="radio"]' ).forEach( function ( btn ) {
			btn.setAttribute( 'aria-checked', 'false' );
			btn.classList.remove( 'is-selected' );
		} );
	}

	/**
	 * @param {HTMLElement} root
	 */
	function resetAllTunnelQuizRadios( root ) {
		root.querySelectorAll( '.tunnel__step--original, .tunnel__step--gestion' ).forEach( function ( step ) {
			resetRadiosInPanel( /** @type {HTMLElement} */ ( step ) );
		} );
	}

	/**
	 * @param {HTMLElement} root
	 */
	function clearAllTunnelAnswers( root ) {
		Object.keys( reponses ).forEach( function ( k ) {
			delete reponses[ k ];
		} );
		Object.keys( gestionReponses ).forEach( function ( k ) {
			delete gestionReponses[ k ];
		} );
		resetAllTunnelQuizRadios( root );
	}

	/**
	 * @param {HTMLElement} root
	 * @param {string} stepKey
	 */
	function restorePanelSelection( root, stepKey ) {
		if ( stepKey.charAt( 0 ) === 'o' ) {
			const n = stepKey.slice( 1 );
			if ( ! Object.prototype.hasOwnProperty.call( reponses, n ) ) {
				return;
			}
			const pts = reponses[ n ];
			const panel = root.querySelector( '#tunnel-step-o-' + n );
			if ( ! panel ) {
				return;
			}
			const group = panel.querySelector( '[role="radiogroup"]' );
			const btn = panel.querySelector(
				'.tunnel__option[data-question="' + n + '"][data-points="' + pts + '"]'
			);
			if ( group && btn ) {
				updateRadios( group, btn );
			}
		} else if ( stepKey.charAt( 0 ) === 'g' ) {
			const gi = parseInt( stepKey.slice( 1 ), 10 );
			const fields = [ 'gestion_salaries', 'gestion_rh', 'gestion_gestion' ];
			const field = fields[ gi - 1 ];
			if ( ! field ) {
				return;
			}
			const val = gestionReponses[ field ];
			if ( ! val ) {
				return;
			}
			const panel = root.querySelector( '#tunnel-step-g-' + gi );
			if ( ! panel ) {
				return;
			}
			const group = panel.querySelector( '[role="radiogroup"]' );
			const btn = panel.querySelector(
				'.tunnel__option[data-gestion-field="' +
					field +
					'"][data-gestion-value="' +
					val +
					'"]'
			);
			if ( group && btn ) {
				updateRadios( group, btn );
			}
		}
	}

	/**
	 * @param {HTMLElement} root
	 */
	function goBack( root ) {
		if ( flowIndex === -2 ) {
			if ( ! userContext ) {
				return;
			}
			flowIndex = PATHS[ userContext ].length;
			afficherQuestion( root );
			return;
		}
		if ( flowIndex <= 0 ) {
			return;
		}
		if ( flowIndex === 1 ) {
			clearAllTunnelAnswers( root );
			userContext = null;
			resetContextRadios( root );
			flowIndex = 0;
			syncTunnelStepsMeta( root );
			afficherQuestion( root );
			setLiveRegion( root, 'Choisissez votre contexte.' );
			return;
		}
		if ( ! userContext ) {
			return;
		}
		const path = PATHS[ userContext ];
		const keyToClear = path[ flowIndex - 1 ];
		clearAnswerForPathKey( keyToClear, root );
		flowIndex -= 1;
		afficherQuestion( root );
		setLiveRegion( root, 'Retour à l’étape ' + ( flowIndex + 1 ) + '.' );
	}

	function panelIdFromKey( key ) {
		if ( key === 'context' ) {
			return 'tunnel-step-context';
		}
		if ( key.charAt( 0 ) === 'o' ) {
			return 'tunnel-step-o-' + key.slice( 1 );
		}
		if ( key.charAt( 0 ) === 'g' ) {
			return 'tunnel-step-g-' + key.slice( 1 );
		}
		return '';
	}

	function headingIdFromKey( key ) {
		if ( key === 'context' ) {
			return 'tunnel-context-heading';
		}
		if ( key.charAt( 0 ) === 'o' ) {
			return 'tunnel-q-o-' + key.slice( 1 ) + '-heading';
		}
		if ( key.charAt( 0 ) === 'g' ) {
			return 'tunnel-q-g-' + key.slice( 1 ) + '-heading';
		}
		return '';
	}

	/**
	 * @returns {string}
	 */
	function getCurrentStepKey() {
		if ( flowIndex === 0 ) {
			return 'context';
		}
		if ( ! userContext ) {
			return 'context';
		}
		const path = PATHS[ userContext ];
		return path[ flowIndex - 1 ] || '';
	}

	/**
	 * @param {HTMLElement} panel
	 * @param {number} stepNum 1-based
	 * @param {number|null} total
	 */
	function updateProgressOnPanel( panel, stepNum, total ) {
		const label = panel.querySelector( '.tunnel__progress-label' );
		const fill = panel.querySelector( '.tunnel__progress-fill' );
		const track = panel.querySelector( '[role="progressbar"]' );
		if ( label ) {
			if ( total === null ) {
				label.textContent = 'Étape 1';
			} else {
				label.textContent = 'Étape ' + stepNum + ' sur ' + total;
			}
		}
		if ( fill && total !== null && total > 0 ) {
			fill.style.width = Math.round( ( stepNum / total ) * 100 ) + '%';
		} else if ( fill && total === null ) {
			fill.style.width = '0%';
		}
		if ( track && total !== null ) {
			track.setAttribute( 'aria-valuemax', String( total ) );
			track.setAttribute( 'aria-valuenow', String( stepNum ) );
		} else if ( track && total === null ) {
			track.setAttribute( 'aria-valuemax', '1' );
			track.setAttribute( 'aria-valuenow', '1' );
		}
	}

	/**
	 * @param {HTMLElement} panel
	 */
	function applyConsultingProjetLabels( panel ) {
		if ( ! panel ) {
			return;
		}
		panel.querySelectorAll( '.tunnel__option' ).forEach( function ( btn ) {
			const def = btn.querySelector( '.tunnel__label-default' );
			const proj = btn.querySelector( '.tunnel__label-projet' );
			if ( ! def || ! proj ) {
				return;
			}
			if ( userContext === 'consulting_projet' ) {
				def.hidden = true;
				proj.hidden = false;
			} else {
				def.hidden = false;
				proj.hidden = true;
			}
		} );
	}

	/**
	 * @param {HTMLElement} group
	 * @param {HTMLElement} selected
	 */
	function updateRadios( group, selected ) {
		const radios = group.querySelectorAll( '[role="radio"]' );
		radios.forEach( function ( btn ) {
			btn.setAttribute( 'aria-checked', btn === selected ? 'true' : 'false' );
			btn.classList.toggle( 'is-selected', btn === selected );
		} );
	}

	/**
	 * @param {HTMLElement} root
	 * @param {string} stepKey
	 */
	function focusStepHeading( root, stepKey ) {
		const id = headingIdFromKey( stepKey );
		if ( ! id ) {
			return;
		}
		const h = root.querySelector( '#' + id );
		if ( h && typeof h.focus === 'function' ) {
			h.focus();
		}
	}

	/**
	 * @param {HTMLElement} root
	 */
	function hideAllQuizPanels( root ) {
		root.querySelectorAll( '.tunnel__step' ).forEach( function ( p ) {
			setVisible( /** @type {HTMLElement} */ ( p ), false );
		} );
	}

	/**
	 * @param {HTMLElement} root
	 * @param {string} stepKey
	 */
	function showQuizPanel( root, stepKey ) {
		hideAllQuizPanels( root );
		const id = panelIdFromKey( stepKey );
		const panel = id ? root.querySelector( '#' + id ) : null;
		if ( panel ) {
			setVisible( panel, true );
			const total = getTotalSteps();
			const stepNum = flowIndex + 1;
			updateProgressOnPanel( panel, stepNum, total );
			applyConsultingProjetLabels( panel );
			restorePanelSelection( root, stepKey );
		}
	}

	/**
	 * @param {HTMLElement} root
	 */
	function afficherQuestion( root ) {
		const intro = root.querySelector( '#tunnel-intro' );
		const stepsWrap = root.querySelector( '#tunnel-steps' );
		const capture = root.querySelector( '#tunnel-capture' );
		const result = root.querySelector( '#tunnel-result' );

		if ( flowIndex === -1 ) {
			setVisible( intro, true );
			setVisible( stepsWrap, false );
			setVisible( capture, false );
			setVisible( result, false );
			setLiveRegion( root, '' );
			return;
		}

		if ( flowIndex === -2 ) {
			return;
		}

		setVisible( intro, false );
		setVisible( stepsWrap, true );
		setVisible( capture, false );
		setVisible( result, false );

		if ( flowIndex === 0 ) {
			syncTunnelStepsMeta( root );
			showQuizPanel( root, 'context' );
			setLiveRegion( root, 'Choisissez votre contexte.' );
			window.requestAnimationFrame( function () {
				focusStepHeading( root, 'context' );
			} );
			return;
		}

		if ( ! userContext ) {
			return;
		}

		if ( flowIndex >= 1 && flowIndex <= PATHS[ userContext ].length ) {
			syncTunnelStepsMeta( root );
			const key = getCurrentStepKey();
			showQuizPanel( root, key );
			setLiveRegion( root, 'Étape ' + ( flowIndex + 1 ) + ' du diagnostic.' );
			window.requestAnimationFrame( function () {
				focusStepHeading( root, key );
			} );
		}
	}

	/**
	 * @param {HTMLElement} root
	 */
	function goToCapture( root ) {
		flowIndex = -2;
		const intro = root.querySelector( '#tunnel-intro' );
		const stepsWrap = root.querySelector( '#tunnel-steps' );
		const capture = root.querySelector( '#tunnel-capture' );
		const result = root.querySelector( '#tunnel-result' );
		setVisible( intro, false );
		hideAllQuizPanels( root );
		setVisible( stepsWrap, true );
		setVisible( capture, true );
		setVisible( result, false );
		setLiveRegion( root, 'Formulaire : indiquez vos coordonnées pour voir votre résultat.' );
		window.requestAnimationFrame( function () {
			const h = root.querySelector( '#tunnel-capture-heading' );
			if ( h && typeof h.focus === 'function' ) {
				h.focus();
			}
		} );
	}

	/**
	 * @param {HTMLElement} root
	 * @param {number} questionId
	 * @param {number} points
	 * @param {HTMLElement} optionBtn
	 */
	function enregistrerReponse( root, questionId, points, optionBtn ) {
		reponses[ String( questionId ) ] = points;
		const group = optionBtn.closest( '[role="radiogroup"]' );
		if ( group ) {
			updateRadios( group, optionBtn );
		}
		flowIndex += 1;
		if ( flowIndex > PATHS[ userContext ].length ) {
			goToCapture( root );
			return;
		}
		afficherQuestion( root );
	}

	/**
	 * @param {HTMLElement} root
	 * @param {string} field
	 * @param {string} value
	 * @param {HTMLElement} optionBtn
	 */
	function enregistrerReponseGestion( root, field, value, optionBtn ) {
		gestionReponses[ field ] = value;
		const group = optionBtn.closest( '[role="radiogroup"]' );
		if ( group ) {
			updateRadios( group, optionBtn );
		}
		flowIndex += 1;
		if ( flowIndex > PATHS[ userContext ].length ) {
			goToCapture( root );
			return;
		}
		afficherQuestion( root );
	}

	/**
	 * @param {HTMLElement} formEl
	 * @param {HTMLElement} errorBox
	 * @param {HTMLInputElement|HTMLSelectElement|HTMLTextAreaElement} input
	 * @param {string} message
	 */
	function setFieldError( formEl, errorBox, input, message ) {
		const errId = input.getAttribute( 'aria-describedby' );
		const errEl = errId ? formEl.querySelector( '#' + errId ) : null;
		input.classList.add( 'is-invalid' );
		input.setAttribute( 'aria-invalid', 'true' );
		if ( errEl ) {
			errEl.textContent = message;
			errEl.hidden = false;
		}
		if ( errorBox ) {
			errorBox.hidden = true;
			errorBox.textContent = '';
		}
	}

	function clearFieldErrors( formEl ) {
		formEl.querySelectorAll( '.is-invalid' ).forEach( function ( el ) {
			el.classList.remove( 'is-invalid' );
			el.setAttribute( 'aria-invalid', 'false' );
		} );
		formEl.querySelectorAll( '.form__error' ).forEach( function ( el ) {
			el.textContent = '';
			el.hidden = true;
		} );
	}

	/**
	 * @param {HTMLFormElement} formEl
	 * @returns {boolean}
	 */
	function validerFormulaireCapture( formEl ) {
		clearFieldErrors( formEl );
		const errorBox = formEl.querySelector( '#tunnel-form-error' );
		let ok = true;
		const requiredMsg = 'Ce champ est obligatoire.';
		const emailMsg = 'Veuillez entrer une adresse email valide.';
		const telMsg = 'Numéro de téléphone invalide.';

		/** @type {Array<{el: HTMLInputElement|HTMLSelectElement, msg: string}>} */
		const checks = [];

		const prenom = formEl.querySelector( '#tunnel-prenom' );
		const nom = formEl.querySelector( '#tunnel-nom' );
		const hotel = formEl.querySelector( '#tunnel-hotel' );
		const email = formEl.querySelector( '#tunnel-email' );
		const tel = formEl.querySelector( '#tunnel-telephone' );
		const typeProjet = formEl.querySelector( '#tunnel-type-projet' );
		const rgpd = formEl.querySelector( '#tunnel-rgpd' );

		if ( prenom && ! prenom.value.trim() ) {
			checks.push( { el: prenom, msg: requiredMsg } );
		}
		if ( nom && ! nom.value.trim() ) {
			checks.push( { el: nom, msg: requiredMsg } );
		}
		if ( hotel && ! hotel.value.trim() ) {
			checks.push( { el: hotel, msg: requiredMsg } );
		}
		if ( email ) {
			if ( ! email.value.trim() ) {
				checks.push( { el: email, msg: requiredMsg } );
			} else if ( ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( email.value ) ) {
				checks.push( { el: email, msg: emailMsg } );
			}
		}
		if ( tel && tel.value.trim() && ! /^[\d\s+.()-]{8,}$/.test( tel.value ) ) {
			checks.push( { el: tel, msg: telMsg } );
		}
		if ( typeProjet && ! typeProjet.value ) {
			checks.push( { el: typeProjet, msg: requiredMsg } );
		}
		if ( rgpd && ! rgpd.checked ) {
			checks.push( { el: rgpd, msg: 'Vous devez accepter le traitement des données.' } );
		}

		checks.forEach( function ( c ) {
			setFieldError( formEl, errorBox, c.el, c.msg );
			ok = false;
		} );

		return ok;
	}

	/**
	 * @returns {boolean}
	 */
	function tunnelReponsesCompletes() {
		if ( ! userContext ) {
			return false;
		}
		if ( userContext === 'gestion' ) {
			let ok = true;
			[ 1, 6, 7, 8, 9, 10 ].forEach( function ( i ) {
				if ( ! Object.prototype.hasOwnProperty.call( reponses, String( i ) ) ) {
					ok = false;
				}
			} );
			[ 'gestion_salaries', 'gestion_rh', 'gestion_gestion' ].forEach( function ( k ) {
				if ( ! gestionReponses[ k ] ) {
					ok = false;
				}
			} );
			return ok;
		}
		for ( let i = 1; i <= 10; i += 1 ) {
			if ( ! Object.prototype.hasOwnProperty.call( reponses, String( i ) ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param {HTMLElement} root
	 * @returns {number} flowIndex de la première étape incomplète, ou -1
	 */
	function getFirstMissingFlowIndex( root ) {
		if ( ! userContext ) {
			return 0;
		}
		const path = PATHS[ userContext ];
		const gestionFields = [ 'gestion_salaries', 'gestion_rh', 'gestion_gestion' ];
		let i = 0;
		while ( i < path.length ) {
			const key = path[ i ];
			const fi = i + 1;
			if ( key.charAt( 0 ) === 'o' ) {
				const qn = parseInt( key.slice( 1 ), 10 );
				if ( ! Object.prototype.hasOwnProperty.call( reponses, String( qn ) ) ) {
					return fi;
				}
			} else if ( key.charAt( 0 ) === 'g' ) {
				const gi = parseInt( key.slice( 1 ), 10 ) - 1;
				const fld = gestionFields[ gi ];
				if ( fld && ! gestionReponses[ fld ] ) {
					return fi;
				}
			}
			i += 1;
		}
		return -1;
	}

	/**
	 * @param {HTMLElement} root
	 */
	function allerPremiereQuestionManquante( root ) {
		const fi = getFirstMissingFlowIndex( root );
		if ( fi < 0 ) {
			return;
		}
		flowIndex = fi;
		const intro = root.querySelector( '#tunnel-intro' );
		const stepsWrap = root.querySelector( '#tunnel-steps' );
		const capture = root.querySelector( '#tunnel-capture' );
		const result = root.querySelector( '#tunnel-result' );
		setVisible( intro, false );
		setVisible( stepsWrap, true );
		setVisible( capture, false );
		setVisible( result, false );
		afficherQuestion( root );
	}

	/**
	 * @param {string} message
	 * @param {HTMLFormElement} formEl
	 */
	function afficherErreur( message, formEl ) {
		const errorBox = formEl.querySelector( '#tunnel-form-error' );
		if ( ! errorBox ) {
			return;
		}
		if ( ! message ) {
			errorBox.textContent = '';
			errorBox.hidden = true;
			return;
		}
		errorBox.textContent = message;
		errorBox.hidden = false;
	}

	/**
	 * @param {number} score
	 * @param {'A'|'B'|'C'} niveau
	 * @param {HTMLElement} root
	 */
	function afficherResultat( score, niveau, root ) {
		const result = root.querySelector( '#tunnel-result' );
		if ( ! result ) {
			return;
		}
		[ 'a', 'b', 'c' ].forEach( function ( letter ) {
			const art = result.querySelector( '#tunnel-resultat-' + letter );
			if ( art ) {
				const show = letter.toUpperCase() === niveau;
				setVisible( art, show );
				if ( show ) {
					art.querySelectorAll( '[data-tunnel-score-display]' ).forEach( function ( span ) {
						span.textContent = String( score );
					} );
				}
			}
		} );
		const intro = root.querySelector( '#tunnel-intro' );
		const stepsWrap = root.querySelector( '#tunnel-steps' );
		const capture = root.querySelector( '#tunnel-capture' );
		setVisible( intro, false );
		hideAllQuizPanels( root );
		setVisible( stepsWrap, true );
		setVisible( capture, false );
		setVisible( result, true );
		setLiveRegion(
			root,
			'Résultat du diagnostic : niveau ' + niveau + ', score ' + score + ' sur 30.'
		);
		window.requestAnimationFrame( function () {
			const map = { A: 'tunnel-resultat-a-heading', B: 'tunnel-resultat-b-heading', C: 'tunnel-resultat-c-heading' };
			const h = root.querySelector( '#' + map[ niveau ] );
			if ( h && typeof h.focus === 'function' ) {
				h.focus();
			}
		} );
	}

	/**
	 * @param {SubmitEvent} e
	 * @param {HTMLElement} root
	 */
	function soumettreFormulaire( e, root ) {
		e.preventDefault();
		const formEl = /** @type {HTMLFormElement} */ ( e.target );
		if ( ! formEl || formEl.getAttribute( 'data-submitting' ) === 'true' || isSubmitting ) {
			return;
		}
		if ( ! validerFormulaireCapture( formEl ) ) {
			return;
		}

		if ( ! tunnelReponsesCompletes() ) {
			afficherErreur( 'Veuillez répondre à toutes les questions.', formEl );
			allerPremiereQuestionManquante( root );
			return;
		}

		isSubmitting = true;
		formEl.setAttribute( 'data-submitting', 'true' );
		const submitBtn = formEl.querySelector( '#tunnel-submit' );
		if ( submitBtn ) {
			submitBtn.disabled = true;
		}
		afficherErreur( '', formEl );

		const payload = new FormData( formEl );
		payload.append( 'action', DIAGNOSTIC_ACTION );
		if ( typeof cbsAjax !== 'undefined' && cbsAjax.nonce ) {
			payload.set( 'nonce', cbsAjax.nonce );
		}
		if ( userContext ) {
			payload.append( 'contexte', userContext );
		}
		for ( let i = 1; i <= 10; i += 1 ) {
			let v;
			if ( userContext === 'gestion' && i >= 2 && i <= 5 ) {
				v = 0;
			} else {
				v = reponses[ String( i ) ];
			}
			payload.append( 'reponses[' + i + ']', String( v ) );
		}

		if ( userContext === 'gestion' ) {
			payload.append( 'gestion_salaries', gestionReponses.gestion_salaries || '' );
			payload.append( 'gestion_rh', gestionReponses.gestion_rh || '' );
			payload.append( 'gestion_gestion', gestionReponses.gestion_gestion || '' );
		}

		const url =
			typeof cbsAjax !== 'undefined' && cbsAjax.url ? cbsAjax.url : '';

		fetchWithTimeout(
			url,
			{
				method: 'POST',
				body: payload,
				credentials: 'same-origin',
			},
			FETCH_TIMEOUT_MS
		)
			.then( function ( response ) {
				return response.json().then( function ( data ) {
					return { ok: response.ok, status: response.status, data: data };
				} );
			} )
			.then( function ( result ) {
				const data = result.data;
				if ( data && data.success && data.data && typeof data.data.score === 'number' && data.data.niveau ) {
					afficherResultat( data.data.score, data.data.niveau, root );
					return;
				}
				let msg = msgGenericError();
				if ( data && data.data ) {
					if ( data.data.message ) {
						msg = data.data.message;
					}
					if ( data.data.code === 'rate_limited' ) {
						msg = data.data.message || msg;
					}
				}
				if ( result.status === 429 ) {
					msg = ( data && data.data && data.data.message ) || msg;
				}
				afficherErreur( msg, formEl );
			} )
			.catch( function ( error ) {
				if ( error && error.name === 'AbortError' ) {
					afficherErreur( msgTimeout(), formEl );
					return;
				}
				if ( typeof navigator !== 'undefined' && navigator.onLine === false ) {
					afficherErreur( msgOffline(), formEl );
					return;
				}
				afficherErreur( msgGenericError(), formEl );
			} )
			.finally( function () {
				isSubmitting = false;
				formEl.setAttribute( 'data-submitting', 'false' );
				if ( submitBtn ) {
					submitBtn.disabled = false;
				}
			} );
	}

	/**
	 * @param {HTMLElement} group
	 */
	function bindRadiogroupKeys( group ) {
		const radios = function () {
			return Array.prototype.slice.call( group.querySelectorAll( '[role="radio"]' ) );
		};
		group.addEventListener( 'keydown', function ( e ) {
			const key = e.key;
			if ( key !== 'ArrowDown' && key !== 'ArrowUp' && key !== 'ArrowRight' && key !== 'ArrowLeft' && key !== 'Home' && key !== 'End' && key !== ' ' && key !== 'Enter' ) {
				return;
			}
			const list = radios();
			const currentIdx = list.indexOf( document.activeElement );
			if ( key === ' ' || key === 'Enter' ) {
				const t = /** @type {HTMLElement|null} */ ( document.activeElement );
				if ( t && t.getAttribute( 'role' ) === 'radio' && list.indexOf( t ) !== -1 ) {
					e.preventDefault();
					t.click();
				}
				return;
			}
			e.preventDefault();
			if ( list.length === 0 ) {
				return;
			}
			let next = currentIdx < 0 ? 0 : currentIdx;
			if ( key === 'ArrowDown' || key === 'ArrowRight' ) {
				next = ( currentIdx + 1 ) % list.length;
			} else if ( key === 'ArrowUp' || key === 'ArrowLeft' ) {
				next = ( currentIdx - 1 + list.length ) % list.length;
			} else if ( key === 'Home' ) {
				next = 0;
			} else if ( key === 'End' ) {
				next = list.length - 1;
			}
			const btn = list[ next ];
			if ( btn && typeof btn.focus === 'function' ) {
				btn.focus();
			}
		} );
	}

	/**
	 * @param {HTMLElement} root
	 */
	function initTunnel( root ) {
		const startBtn = root.querySelector( '[data-tunnel-start]' );
		if ( startBtn ) {
			startBtn.addEventListener( 'click', function () {
				flowIndex = 0;
				userContext = null;
				Object.keys( reponses ).forEach( function ( k ) {
					delete reponses[ k ];
				} );
				Object.keys( gestionReponses ).forEach( function ( k ) {
					delete gestionReponses[ k ];
				} );
				resetContextRadios( root );
				resetAllTunnelQuizRadios( root );
				syncTunnelStepsMeta( root );
				afficherQuestion( root );
			} );
		}

		root.querySelectorAll( '[role="radiogroup"]' ).forEach( function ( group ) {
			bindRadiogroupKeys( /** @type {HTMLElement} */ ( group ) );
		} );

		root.querySelectorAll( '.tunnel__option--context' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				const tag = btn.getAttribute( 'data-user-context' );
				if ( ! tag || ! PATHS[ tag ] ) {
					return;
				}
				userContext = /** @type {'consulting_projet'|'consulting_existant'|'gestion'} */ ( tag );
				const group = btn.closest( '[role="radiogroup"]' );
				if ( group ) {
					updateRadios( group, /** @type {HTMLElement} */ ( btn ) );
				}
				flowIndex = 1;
				syncTunnelStepsMeta( root );
				afficherQuestion( root );
			} );
		} );

		root.addEventListener( 'click', function ( e ) {
			const t = e.target;
			if ( ! t || typeof t !== 'object' || ! ( /** @type {HTMLElement} */ ( t ).closest ) ) {
				return;
			}
			const back = /** @type {HTMLElement} */ ( t ).closest( '[data-tunnel-back]' );
			if ( ! back || ! root.contains( back ) ) {
				return;
			}
			e.preventDefault();
			goBack( root );
		} );

		root.querySelectorAll( '.tunnel__option:not(.tunnel__option--context):not(.tunnel__option--gestion)' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				const questionId = btn.getAttribute( 'data-question' );
				const pts = parseInt( btn.getAttribute( 'data-points' ) || '0', 10 );
				if ( ! questionId || Number.isNaN( pts ) ) {
					return;
				}
				enregistrerReponse( root, questionId, pts, /** @type {HTMLElement} */ ( btn ) );
			} );
		} );

		root.querySelectorAll( '.tunnel__option--gestion' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				const field = btn.getAttribute( 'data-gestion-field' );
				const value = btn.getAttribute( 'data-gestion-value' );
				if ( ! field || ! value ) {
					return;
				}
				enregistrerReponseGestion( root, field, value, /** @type {HTMLElement} */ ( btn ) );
			} );
		} );

		const form = root.querySelector( '#tunnel-form-capture' );
		if ( form ) {
			form.addEventListener( 'submit', function ( ev ) {
				soumettreFormulaire( ev, root );
			} );
		}

		flowIndex = -1;
		afficherQuestion( root );
	}

	if ( typeof cbsAjax === 'undefined' ) {
		return;
	}

	const root = document.querySelector( '#tunnel-root' );
	if ( root ) {
		initTunnel( /** @type {HTMLElement} */ ( root ) );
	}
} )();
