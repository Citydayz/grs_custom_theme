<?php
/**
 * CBS Theme — CTA final / RDV (content-structure.md §2 section 6)
 *
 * Embed Calendly si URL inline (`CBS_CALENDLY_INLINE_URL` ou filtre) **et**
 * champ ACF `cbs_afficher_calendly` activé sur la page (scripts chargés dans ce cas).
 * Sinon lien vers /contact/.
 */
defined( 'ABSPATH' ) || exit;

$page_id = (int) get_queried_object_id();
$calendly_enabled = $page_id > 0
	&& function_exists( 'get_field' )
	&& (bool) get_field( 'cbs_afficher_calendly', $page_id );

$calendly_url = cbs_get_calendly_inline_url();
$has_embed    = $calendly_url !== '' && $calendly_enabled;
?>
<section class="cbs-section cta-rdv" aria-labelledby="cta-rdv-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="cta-rdv-heading" class="cta-rdv__title">
			<?php esc_html_e( 'Discutons de votre projet spa', 'cbs-theme' ); ?>
		</h2>
		<p class="cta-rdv__text">
			<?php esc_html_e( "Chaque projet est unique. Je vous propose un premier échange pour comprendre vos enjeux et voir comment je peux vous accompagner.", 'cbs-theme' ); ?>
		</p>

		<?php if ( $has_embed ) : ?>
			<div
				class="calendly-inline-widget cta-rdv__calendly"
				data-url="<?php echo esc_url( $calendly_url ); ?>"
				style="min-width: 320px; height: 700px;"
				role="region"
				aria-label="<?php esc_attr_e( 'Prise de rendez-vous en ligne', 'cbs-theme' ); ?>"
			></div>
			<p class="cta-rdv__fallback">
				<a class="cta-rdv__fallback-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php esc_html_e( 'Ou accéder au formulaire de contact', 'cbs-theme' ); ?>
				</a>
			</p>
		<?php else : ?>
			<a class="btn-primary cta-rdv__button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Prendre rendez-vous', 'cbs-theme' ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
