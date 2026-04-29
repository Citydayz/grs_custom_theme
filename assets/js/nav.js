/**
 * CBS Theme — navigation (navigation.md §2, §3, §4)
 */
(function () {
	'use strict';

	const FOCUSABLE =
		'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])';

	function getDropdown(item) {
		return item.querySelector('.nav__dropdown');
	}

	function getSubmenuToggle(item) {
		return item.querySelector('.nav__submenu-toggle');
	}

	function closeItem(item) {
		const toggle = getSubmenuToggle(item);
		const dropdown = getDropdown(item);
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'false');
		}
		if (dropdown) {
			dropdown.setAttribute('hidden', '');
		}
	}

	function openItem(item) {
		const toggle = getSubmenuToggle(item);
		const dropdown = getDropdown(item);
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'true');
		}
		if (dropdown) {
			dropdown.removeAttribute('hidden');
		}
	}

	function closeAllDropdowns() {
		document.querySelectorAll('.nav__item--has-children').forEach((item) => {
			closeItem(item);
		});
	}

	function closeMobileMenu(toggle, menu) {
		toggle.setAttribute('aria-expanded', 'false');
		if (toggle.dataset.cbsLabelOpen) {
			toggle.setAttribute('aria-label', toggle.dataset.cbsLabelOpen);
		}
		menu.setAttribute('aria-hidden', 'true');
		menu.classList.remove('is-open');
		document.body.classList.remove('menu-is-open');
		document.body.style.overflow = '';
		closeAllDropdowns();
	}

	function initMobileNav() {
		const toggle = document.querySelector('.nav__toggle');
		const menu = document.querySelector('.nav__menu');

		if (!toggle || !menu) {
			return;
		}

		const mqDesktop = window.matchMedia('(min-width: 1024px)');

		function syncMobileNavForViewport() {
			if (mqDesktop.matches) {
				menu.setAttribute('aria-hidden', 'false');
				toggle.setAttribute('aria-expanded', 'false');
				if (toggle.dataset.cbsLabelOpen) {
					toggle.setAttribute('aria-label', toggle.dataset.cbsLabelOpen);
				}
				menu.classList.remove('is-open');
				document.body.classList.remove('menu-is-open');
				document.body.style.overflow = '';
				closeAllDropdowns();
			} else {
				const open = menu.classList.contains('is-open');
				menu.setAttribute('aria-hidden', open ? 'false' : 'true');
			}
		}

		mqDesktop.addEventListener('change', syncMobileNavForViewport);
		syncMobileNavForViewport();

		toggle.addEventListener('click', () => {
			const isOpen = toggle.getAttribute('aria-expanded') === 'true';
			const labelOpen = toggle.dataset.cbsLabelOpen || '';
			const labelClose = toggle.dataset.cbsLabelClose || '';

			toggle.setAttribute('aria-expanded', String(!isOpen));
			if (labelOpen && labelClose) {
				toggle.setAttribute('aria-label', isOpen ? labelOpen : labelClose);
			}
			menu.setAttribute('aria-hidden', String(isOpen));
			menu.classList.toggle('is-open', !isOpen);
			document.body.classList.toggle('menu-is-open', !isOpen);
			document.body.style.overflow = isOpen ? '' : 'hidden';

			if (!isOpen) {
				menu.querySelector(FOCUSABLE)?.focus();
			}
		});

		document.addEventListener('keydown', (e) => {
			if (e.key !== 'Escape') {
				return;
			}
			if (toggle.getAttribute('aria-expanded') !== 'true') {
				return;
			}

			closeMobileMenu(toggle, menu);
			toggle.focus();
		});

		document.addEventListener('click', (e) => {
			if (toggle.getAttribute('aria-expanded') !== 'true') {
				return;
			}
			if (menu.contains(e.target) || toggle.contains(e.target)) {
				return;
			}

			closeMobileMenu(toggle, menu);
			toggle.focus();
		});
	}

	function initDropdowns() {
		const items = document.querySelectorAll('.nav__item--has-children');

		if (!items.length) {
			return;
		}

		const mqDesktop = window.matchMedia('(min-width: 1024px)');
		const canHover = window.matchMedia('(hover: hover)');

		function useHoverDropdowns() {
			return mqDesktop.matches && canHover.matches;
		}

		items.forEach((item) => {
			const toggle = getSubmenuToggle(item);
			const dropdown = getDropdown(item);

			if (!toggle || !dropdown) {
				return;
			}

			/* Desktop avec souris : survol + focus clavier (le lien parent reste cliquable pour la page) */
			item.addEventListener('mouseenter', () => {
				if (!useHoverDropdowns()) {
					return;
				}
				items.forEach((other) => {
					if (other !== item) {
						closeItem(other);
					}
				});
				openItem(item);
			});

			item.addEventListener('mouseleave', () => {
				if (!useHoverDropdowns()) {
					return;
				}
				closeItem(item);
			});

			item.addEventListener('focusin', () => {
				if (!mqDesktop.matches) {
					return;
				}
				items.forEach((other) => {
					if (other !== item) {
						closeItem(other);
					}
				});
				openItem(item);
			});

			item.addEventListener('focusout', (e) => {
				if (!mqDesktop.matches) {
					return;
				}
				if (item.contains(e.relatedTarget)) {
					return;
				}
				closeItem(item);
			});

			toggle.addEventListener('click', (e) => {
				/* Grand écran + souris : le chevron ne fait qu’indiquer ; l’ouverture est au survol */
				if (useHoverDropdowns()) {
					e.preventDefault();
					return;
				}
				e.preventDefault();
				e.stopPropagation();

				const isOpen = toggle.getAttribute('aria-expanded') === 'true';

				items.forEach((other) => {
					if (other !== item) {
						closeItem(other);
					}
				});

				if (isOpen) {
					closeItem(item);
				} else {
					openItem(item);
					dropdown.querySelector(FOCUSABLE)?.focus();
				}
			});
		});

		document.addEventListener('click', (e) => {
			if (e.target.closest('.nav__item--has-children')) {
				return;
			}
			closeAllDropdowns();
		});

		document.addEventListener('keydown', (e) => {
			if (e.key !== 'Escape') {
				return;
			}
			const navToggle = document.querySelector('.nav__toggle');
			if (navToggle && navToggle.getAttribute('aria-expanded') === 'true') {
				return;
			}
			const openToggle = document.querySelector('.nav__submenu-toggle[aria-expanded="true"]');
			if (!openToggle) {
				return;
			}
			closeAllDropdowns();
			openToggle.focus();
		});
	}

	function init() {
		initMobileNav();
		initDropdowns();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
