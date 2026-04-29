<?php
/**
 * CBS Theme — Capture coordonnées avant résultat (diagnostic-tunnel.md §5).
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

$diagnostic_types = function_exists( 'cbs_diagnostic_type_projet_map' ) ? cbs_diagnostic_type_projet_map() : array();
?>
<div
	class="tunnel__panel tunnel__panel--capture"
	id="tunnel-capture"
	data-tunnel-step="11"
	data-tunnel-panel="11"
	hidden
>
	<div class="tunnel__step-toolbar">
		<button type="button" class="tunnel__back" data-tunnel-back>
			<?php esc_html_e( '← Retour', 'cbs-theme' ); ?>
		</button>
	</div>
	<h2 class="tunnel__capture-title" id="tunnel-capture-heading" tabindex="-1">
		<?php esc_html_e( 'Recevez votre résultat détaillé', 'cbs-theme' ); ?>
	</h2>
	<p class="tunnel__capture-lead">
		<?php esc_html_e( 'Indiquez vos coordonnées pour accéder à votre niveau de diagnostic et recevoir vos points de vigilance prioritaires.', 'cbs-theme' ); ?>
	</p>

	<form
		class="cbs-form tunnel__form"
		id="tunnel-form-capture"
		novalidate
		aria-labelledby="tunnel-capture-heading"
		data-submitting="false"
	>
		<?php wp_nonce_field( 'cbs_tunnel_nonce', 'nonce' ); ?>

		<div class="form__honeypot" aria-hidden="true">
			<label for="tunnel-website"><?php esc_html_e( 'Ne pas remplir ce champ', 'cbs-theme' ); ?></label>
			<input type="text" id="tunnel-website" name="website" tabindex="-1" autocomplete="off">
		</div>

		<p id="tunnel-form-error" class="tunnel__form-error" role="alert" hidden></p>

		<div class="form__group">
			<label class="form__label" for="tunnel-prenom">
				<?php esc_html_e( 'Prénom', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="text"
				id="tunnel-prenom"
				name="prenom"
				required
				aria-required="true"
				aria-describedby="tunnel-prenom-error"
				autocomplete="given-name"
			>
			<span class="form__error" id="tunnel-prenom-error" role="alert" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="tunnel-nom">
				<?php esc_html_e( 'Nom', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="text"
				id="tunnel-nom"
				name="nom"
				required
				aria-required="true"
				aria-describedby="tunnel-nom-error"
				autocomplete="family-name"
			>
			<span class="form__error" id="tunnel-nom-error" role="alert" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="tunnel-hotel">
				<?php esc_html_e( 'Hôtel / Société', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="text"
				id="tunnel-hotel"
				name="hotel"
				required
				aria-required="true"
				aria-describedby="tunnel-hotel-error"
				autocomplete="organization"
			>
			<span class="form__error" id="tunnel-hotel-error" role="alert" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="tunnel-email">
				<?php esc_html_e( 'Email', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<input
				class="form__input"
				type="email"
				id="tunnel-email"
				name="email"
				required
				aria-required="true"
				aria-describedby="tunnel-email-error"
				autocomplete="email"
			>
			<span class="form__error" id="tunnel-email-error" role="alert" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="tunnel-telephone"><?php esc_html_e( 'Téléphone', 'cbs-theme' ); ?></label>
			<input
				class="form__input"
				type="tel"
				id="tunnel-telephone"
				name="telephone"
				aria-describedby="tunnel-telephone-error"
				autocomplete="tel"
			>
			<span class="form__error" id="tunnel-telephone-error" role="alert" hidden></span>
		</div>

		<div class="form__group">
			<label class="form__label" for="tunnel-type-projet">
				<?php esc_html_e( 'Type de projet', 'cbs-theme' ); ?>
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<select
				class="form__select"
				id="tunnel-type-projet"
				name="type_projet"
				required
				aria-required="true"
				aria-describedby="tunnel-type-projet-error"
			>
				<option value=""><?php esc_html_e( 'Sélectionnez…', 'cbs-theme' ); ?></option>
				<?php foreach ( $diagnostic_types as $slug => $label ) : ?>
					<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
			<span class="form__error" id="tunnel-type-projet-error" role="alert" hidden></span>
		</div>

		<div class="form__group form__group--checkbox">
			<input type="checkbox" id="tunnel-rgpd" name="rgpd" value="1" required aria-required="true" aria-describedby="tunnel-rgpd-error">
			<label for="tunnel-rgpd">
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
				<span class="form__required" aria-label="<?php esc_attr_e( 'champ obligatoire', 'cbs-theme' ); ?>">*</span>
			</label>
			<span class="form__error form__error--checkbox" id="tunnel-rgpd-error" role="alert" aria-live="assertive" hidden></span>
		</div>

		<div class="tunnel__form-actions">
			<button type="submit" class="btn-primary tunnel__submit" id="tunnel-submit">
				<?php esc_html_e( 'Voir mon résultat', 'cbs-theme' ); ?>
			</button>
		</div>
	</form>
</div>
