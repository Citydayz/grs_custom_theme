<?php
/**
 * CBS Theme — Formulaire de contact AJAX (forms.md §2, content-structure.md §10).
 */
defined( 'ABSPATH' ) || exit;
?>
<form
	class="cbs-form"
	id="form-contact"
	novalidate
	aria-labelledby="contact-form-label"
>
	<div class="form__row">
		<div class="form__group">
			<label class="form__label" for="cbs-prenom">
				<?php esc_html_e( 'Prénom', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="text"
				id="cbs-prenom"
				name="prenom"
				required
				aria-required="true"
				aria-describedby="cbs-prenom-error"
				autocomplete="given-name"
			>
			<span class="form__error" id="cbs-prenom-error" role="alert" aria-live="assertive" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="cbs-nom">
				<?php esc_html_e( 'Nom', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="text"
				id="cbs-nom"
				name="nom"
				required
				aria-required="true"
				aria-describedby="cbs-nom-error"
				autocomplete="family-name"
			>
			<span class="form__error" id="cbs-nom-error" role="alert" aria-live="assertive" hidden></span>
		</div>
	</div>

	<div class="form__group">
		<label class="form__label" for="cbs-hotel">
			<?php esc_html_e( 'Hôtel / Société', 'cbs-theme' ); ?>
			<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
		</label>
		<input
			class="form__input"
			type="text"
			id="cbs-hotel"
			name="hotel"
			required
			aria-required="true"
			aria-describedby="cbs-hotel-error"
			autocomplete="organization"
		>
		<span class="form__error" id="cbs-hotel-error" role="alert" aria-live="assertive" hidden></span>
	</div>

	<div class="form__row">
		<div class="form__group">
			<label class="form__label" for="cbs-email">
				<?php esc_html_e( 'Email', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="email"
				id="cbs-email"
				name="email"
				required
				aria-required="true"
				aria-describedby="cbs-email-error"
				autocomplete="email"
			>
			<span class="form__error" id="cbs-email-error" role="alert" aria-live="assertive" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="cbs-telephone"><?php esc_html_e( 'Téléphone', 'cbs-theme' ); ?></label>
			<input
				class="form__input"
				type="tel"
				id="cbs-telephone"
				name="telephone"
				aria-describedby="cbs-telephone-error"
				autocomplete="tel"
			>
			<span class="form__error" id="cbs-telephone-error" role="alert" aria-live="assertive" hidden></span>
		</div>
	</div>

	<div class="form__group">
		<label class="form__label" for="cbs-type-projet">
			<?php esc_html_e( 'Type de projet', 'cbs-theme' ); ?>
			<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
		</label>
		<select
			class="form__select"
			id="cbs-type-projet"
			name="type_projet"
			required
			aria-required="true"
			aria-describedby="cbs-type-projet-error"
		>
			<option value="" disabled selected><?php esc_html_e( 'Choisissez…', 'cbs-theme' ); ?></option>
			<option value="conseil"><?php esc_html_e( 'Conseil', 'cbs-theme' ); ?></option>
			<option value="gestion"><?php esc_html_e( 'Gestion', 'cbs-theme' ); ?></option>
			<option value="staffing"><?php esc_html_e( 'Staffing', 'cbs-theme' ); ?></option>
			<option value="autre"><?php esc_html_e( 'Autre', 'cbs-theme' ); ?></option>
		</select>
		<span class="form__error" id="cbs-type-projet-error" role="alert" aria-live="assertive" hidden></span>
	</div>

	<div class="form__group">
		<label class="form__label" for="cbs-message"><?php esc_html_e( 'Message', 'cbs-theme' ); ?></label>
		<textarea
			class="form__textarea"
			id="cbs-message"
			name="message"
			rows="5"
			aria-describedby="cbs-message-error"
		></textarea>
		<span class="form__error" id="cbs-message-error" role="alert" aria-live="assertive" hidden></span>
	</div>

	<div class="form__group form__group--checkbox">
		<input type="checkbox" id="cbs-rgpd" name="rgpd" value="1" required aria-required="true" aria-describedby="cbs-rgpd-error">
		<label for="cbs-rgpd">
			<?php
			$policy_href = esc_url( home_url( '/politique-de-confidentialite/' ) );
			$policy_link = sprintf(
				'<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>',
				$policy_href,
				esc_html__( 'politique de confidentialité', 'cbs-theme' )
			);
			echo wp_kses_post(
				sprintf(
					/* translators: %s: lien HTML vers la politique de confidentialité */
					__( 'J’accepte que mes données soient traitées conformément à la %s.', 'cbs-theme' ),
					$policy_link
				)
			);
			?>
		</label>
		<span class="form__error form__error--checkbox" id="cbs-rgpd-error" role="alert" aria-live="assertive" hidden></span>
	</div>

	<?php wp_nonce_field( 'cbs_contact_nonce', 'cbs_nonce' ); ?>

	<div class="form__honeypot" aria-hidden="true">
		<label for="cbs-website"><?php esc_html_e( 'Ne pas remplir ce champ', 'cbs-theme' ); ?></label>
		<input type="text" id="cbs-website" name="website" tabindex="-1" autocomplete="off">
	</div>

	<button type="submit" class="btn-primary form__submit">
		<?php esc_html_e( 'Envoyer ma demande', 'cbs-theme' ); ?>
	</button>

	<div class="form__feedback" role="status" aria-live="polite" hidden tabindex="-1"></div>
</form>
