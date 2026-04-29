# forms.md — Formulaires Custom
# Conseil & Gestion des rituels du spa by Camille Becht

> Ce fichier documente les règles de construction et de comportement
> de tous les formulaires custom du site.
> Cursor doit s'y référer pour tout travail sur le formulaire contact,
> la capture email du tunnel et tout futur formulaire.
>
> Rappel : pas de Contact Form 7 ni de plugin de formulaire — tout est custom AJAX.

---

## 1. Formulaires du site

| Formulaire | Template | Handler AJAX | Usage |
|---|---|---|---|
| Contact | `template-contact.php` | `cbs_handle_contact_form` | Page /contact/ |
| Capture diagnostic | `tunnel-capture.php` | `cbs_handle_diagnostic_submit` | Étape 11 du tunnel |

---

## 2. Structure HTML standard

Chaque formulaire suit ce patron strict :

```html
<form
    class="cbs-form"
    id="form-[nom]"
    novalidate
    aria-label="[Description du formulaire]"
>
    <!-- Champ standard -->
    <div class="form__group">
        <label class="form__label" for="cbs-[champ]">
            Votre prénom
            <span class="form__required" aria-label="champ obligatoire">*</span>
        </label>
        <input
            class="form__input"
            type="text"
            id="cbs-[champ]"
            name="[champ]"
            required
            aria-required="true"
            aria-describedby="cbs-[champ]-error"
            autocomplete="given-name"
        >
        <span
            class="form__error"
            id="cbs-[champ]-error"
            role="alert"
            aria-live="assertive"
            hidden
        ></span>
    </div>

    <!-- Champ select -->
    <div class="form__group">
        <label class="form__label" for="cbs-type-projet">
            Type de projet <span aria-label="champ obligatoire">*</span>
        </label>
        <select class="form__select" id="cbs-type-projet" name="type_projet"
                required aria-required="true">
            <option value="" disabled selected>Choisissez…</option>
            <option value="creation">Création d'un spa</option>
            <option value="optimisation">Spa existant à optimiser</option>
            <option value="reflexion">Réflexion stratégique</option>
            <option value="gestion">Gestion / staffing</option>
        </select>
    </div>

    <!-- RGPD obligatoire -->
    <div class="form__group form__group--checkbox">
        <input type="checkbox" id="cbs-rgpd" name="rgpd" required
               aria-required="true">
        <label for="cbs-rgpd">
            J'accepte que mes données soient traitées conformément à la
            <a href="/politique-de-confidentialite/" target="_blank">
                politique de confidentialité
            </a>.
        </label>
    </div>

    <!-- Nonce WordPress — obligatoire -->
    <?php wp_nonce_field( 'cbs_contact_nonce', 'cbs_nonce' ); ?>

    <!-- Honeypot anti-spam — champ caché, doit rester vide -->
    <div class="form__honeypot" aria-hidden="true">
        <input type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    <!-- Bouton de soumission -->
    <button type="submit" class="btn-primary form__submit">
        Envoyer ma demande
    </button>

    <!-- Zone de feedback global -->
    <div class="form__feedback" role="status" aria-live="polite" hidden></div>
</form>
```

---

## 3. États visuels des champs

```css
/* assets/css/components/forms.css */

/* État par défaut */
.form__input,
.form__select {
    border: 1px solid var(--cbs-silver-300);
    background: var(--cbs-silver-100);
    transition: border-color var(--cbs-transition-fast);
}

/* Focus */
.form__input:focus,
.form__select:focus {
    border-color: var(--cbs-silver-700);
    outline: 2px solid var(--cbs-gold);
    outline-offset: 2px;
}

/* Valide (après interaction) */
.form__input.is-valid {
    border-color: var(--cbs-success);
}

/* Invalide */
.form__input.is-invalid {
    border-color: var(--cbs-error);
}

/* Message d'erreur */
.form__error {
    color: var(--cbs-error);
    font-size: var(--cbs-text-small);
    margin-top: var(--cbs-space-2);
}

/* Champ désactivé pendant soumission */
.form__input:disabled,
.form__submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Honeypot — visuellement invisible */
.form__honeypot {
    position: absolute;
    left: -9999px;
    width: 1px;
    height: 1px;
    overflow: hidden;
}
```

---

## 4. Validation JS — côté client

```javascript
// assets/js/forms.js

/**
 * Valide un champ et affiche/masque le message d'erreur.
 * Retourne true si valide, false sinon.
 */
function validerChamp( input ) {
    const errorEl = document.getElementById( input.id + '-error' );
    let message = '';

    if ( input.required && ! input.value.trim() ) {
        message = 'Ce champ est obligatoire.';
    } else if ( input.type === 'email' && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( input.value ) ) {
        message = 'Veuillez entrer une adresse email valide.';
    } else if ( input.type === 'tel' && input.value && ! /^[\d\s\+\-\.]{8,}$/.test( input.value ) ) {
        message = 'Numéro de téléphone invalide.';
    }

    if ( message ) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        input.setAttribute('aria-invalid', 'true');
        if ( errorEl ) {
            errorEl.textContent = message;
            errorEl.removeAttribute('hidden');
        }
        return false;
    }

    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    input.setAttribute('aria-invalid', 'false');
    if ( errorEl ) {
        errorEl.textContent = '';
        errorEl.setAttribute('hidden', '');
    }
    return true;
}

/**
 * Initialise la validation en temps réel sur tous les champs d'un formulaire.
 */
function initFormValidation( formEl ) {
    const inputs = formEl.querySelectorAll('.form__input, .form__select');

    inputs.forEach( input => {
        // Validation au blur (quand l'utilisateur quitte le champ)
        input.addEventListener('blur', () => validerChamp(input));

        // Re-validation à la saisie si déjà en erreur
        input.addEventListener('input', () => {
            if ( input.classList.contains('is-invalid') ) {
                validerChamp(input);
            }
        });
    });
}

/**
 * Soumet un formulaire via AJAX.
 */
async function soumettreFormulaire( formEl, action ) {
    // Protection double soumission
    if ( formEl.dataset.submitting === 'true' ) return;
    formEl.dataset.submitting = 'true';

    const submitBtn = formEl.querySelector('.form__submit');
    const feedback  = formEl.querySelector('.form__feedback');
    const labelOriginal = submitBtn?.textContent;

    // Désactiver le formulaire
    formEl.querySelectorAll('input, select, textarea, button').forEach(
        el => el.disabled = true
    );
    if ( submitBtn ) submitBtn.textContent = 'Envoi en cours…';

    try {
        const formData = new FormData(formEl);
        formData.append('action', action);

        const response = await fetch(cbsAjax.url, {
            method: 'POST',
            body: formData,
            signal: AbortSignal.timeout(15000),
        });

        const data = await response.json();

        if ( data.success ) {
            afficherSucces( formEl, feedback );
        } else {
            afficherErreurFormulaire(
                feedback,
                data.data?.message || 'Une erreur est survenue. Réessayez.'
            );
        }

    } catch ( error ) {
        const message = ! navigator.onLine
            ? 'Vérifiez votre connexion internet.'
            : 'Une erreur est survenue. Réessayez dans quelques instants.';
        afficherErreurFormulaire( feedback, message );

    } finally {
        formEl.dataset.submitting = 'false';
        formEl.querySelectorAll('input, select, textarea, button').forEach(
            el => el.disabled = false
        );
        if ( submitBtn ) submitBtn.textContent = labelOriginal;
    }
}

function afficherSucces( formEl, feedbackEl ) {
    formEl.reset();
    formEl.querySelectorAll('.is-valid, .is-invalid').forEach(
        el => el.classList.remove('is-valid', 'is-invalid')
    );
    if ( feedbackEl ) {
        feedbackEl.textContent = 'Votre message a bien été envoyé. Nous vous répondrons sous 24h.';
        feedbackEl.className = 'form__feedback form__feedback--success';
        feedbackEl.removeAttribute('hidden');
        feedbackEl.focus();
    }
}

function afficherErreurFormulaire( feedbackEl, message ) {
    if ( feedbackEl ) {
        feedbackEl.textContent = message;
        feedbackEl.className = 'form__feedback form__feedback--error';
        feedbackEl.removeAttribute('hidden');
        feedbackEl.focus();
    }
}
```

---

## 5. Handler PHP — formulaire contact

```php
// inc/ajax.php
add_action( 'wp_ajax_nopriv_cbs_contact_form', 'cbs_handle_contact_form' );
add_action( 'wp_ajax_cbs_contact_form',        'cbs_handle_contact_form' );

function cbs_handle_contact_form(): void {
    // 1. Sécurité
    check_ajax_referer( 'cbs_contact_nonce', 'cbs_nonce' );

    // 2. Honeypot anti-spam
    if ( ! empty( $_POST['website'] ) ) {
        wp_send_json_success(); // Leurrer le bot — pas d'erreur
        return;
    }

    // 3. Rate limiting
    if ( ! cbs_check_rate_limit( 'contact', 3, 3600 ) ) {
        wp_send_json_error([
            'message' => 'Trop de tentatives. Réessayez dans une heure.',
        ], 429);
    }

    // 4. Sanitization
    $prenom      = sanitize_text_field( $_POST['prenom']      ?? '' );
    $nom         = sanitize_text_field( $_POST['nom']         ?? '' );
    $hotel       = sanitize_text_field( $_POST['hotel']       ?? '' );
    $email       = sanitize_email(      $_POST['email']       ?? '' );
    $telephone   = sanitize_text_field( $_POST['telephone']   ?? '' );
    $type_projet = sanitize_text_field( $_POST['type_projet'] ?? '' );
    $message     = sanitize_textarea_field( $_POST['message'] ?? '' );

    // 5. Validation
    $types_valides = ['creation', 'optimisation', 'reflexion', 'gestion'];
    if ( empty($prenom) || ! is_email($email) || ! in_array($type_projet, $types_valides, true) ) {
        wp_send_json_error(['message' => 'Données invalides. Vérifiez et réessayez.'], 400);
    }

    // 6. Enregistrement Airtable
    $result = cbs_send_to_airtable( CBS_AIRTABLE_TABLE_DIAGNOSTICS, [
        'Prénom'       => $prenom,
        'Nom'          => $nom,
        'Hôtel'        => $hotel,
        'Email'        => $email,
        'Téléphone'    => $telephone,
        'Type projet'  => $type_projet,
        'Message'      => $message,
        'Source'       => 'Formulaire contact',
        'Statut lead'  => 'Nouveau',
        'Date'         => current_time('Y-m-d H:i:s'),
    ]);

    if ( is_wp_error($result) ) {
        cbs_log_error('airtable', $result->get_error_message());
    }

    // 7. Webhook Make
    cbs_trigger_make_webhook('contact_form', [
        'prenom'      => $prenom,
        'email'       => $email,
        'hotel'       => $hotel,
        'type_projet' => $type_projet,
    ]);

    wp_send_json_success([
        'message' => 'Votre message a bien été envoyé. Nous vous répondrons sous 24h.',
    ]);
}
```

---

## 6. Anti-spam — honeypot

Chaque formulaire intègre un champ honeypot invisible :

```html
<!-- Invisible visuellement et pour les vrais utilisateurs -->
<div class="form__honeypot" aria-hidden="true">
    <input type="text" name="website" tabindex="-1" autocomplete="off">
</div>
```

```php
// Côté PHP : si le champ est rempli → c'est un bot
if ( ! empty( $_POST['website'] ) ) {
    wp_send_json_success(); // Simuler un succès pour ne pas alerter le bot
    return;
}
```

---

## 7. Checklist formulaires

- [ ] `novalidate` sur le `<form>` (validation gérée en JS)
- [ ] `wp_nonce_field()` dans chaque formulaire
- [ ] Honeypot présent
- [ ] Chaque `<input>` a un `<label>` associé via `for` + `id`
- [ ] `aria-describedby` pointant vers le span d'erreur
- [ ] `role="alert"` sur les spans d'erreur
- [ ] `role="status"` sur la zone de feedback global
- [ ] Case RGPD obligatoire
- [ ] Protection double soumission active
- [ ] Rate limiting côté PHP
- [ ] Honeypot vérifié côté PHP
- [ ] Fallback Airtable — UX non bloquée si API down

---

*Référence : security.md §2-3, accessibility.md §5, error-handling.md §5*
