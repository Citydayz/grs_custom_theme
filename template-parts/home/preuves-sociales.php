<?php
/**
 * CBS Theme — Preuves sociales (content-structure.md §2 section 5)
 *
 * ACF (page d’accueil) — groupe « CBS — Page Accueil » :
 * - Repeater `cbs_accueil_temoignages` : `cbs_temoignage_texte`, `cbs_temoignage_auteur`, `cbs_temoignage_etablissement`
 * - Repeater `cbs_accueil_logos` : `cbs_logo_partenaire` (image), `cbs_logo_alt`
 */
defined( 'ABSPATH' ) || exit;

$page_id = (int) get_queried_object_id();
$temoignages = [];
$logos        = [];

if ( $page_id && function_exists( 'get_field' ) ) {
	$raw_t = get_field( 'cbs_accueil_temoignages', $page_id );
	if ( is_array( $raw_t ) ) {
		$temoignages = $raw_t;
	}
	$raw_l = get_field( 'cbs_accueil_logos', $page_id );
	if ( is_array( $raw_l ) ) {
		$logos = $raw_l;
	}
}
?>
<section class="cbs-section social-proof" aria-labelledby="social-proof-heading">
	<div class="cbs-container">
		<h2 id="social-proof-heading" class="social-proof__title">
			<?php esc_html_e( 'Chiffres clés & références', 'cbs-theme' ); ?>
		</h2>

		<ul class="social-proof__stats" role="list">
			<li class="social-proof__stat">
				<span class="social-proof__stat-value"><?php esc_html_e( '+10', 'cbs-theme' ); ?></span>
				<span class="social-proof__stat-label"><?php esc_html_e( 'hôtels 4★ accompagnés', 'cbs-theme' ); ?></span>
			</li>
			<li class="social-proof__stat">
				<span class="social-proof__stat-value"><?php esc_html_e( '5★', 'cbs-theme' ); ?></span>
				<span class="social-proof__stat-label"><?php esc_html_e( 'Hôtels 5★ et groupes hôteliers', 'cbs-theme' ); ?></span>
			</li>
			<li class="social-proof__stat">
				<span class="social-proof__stat-value"><?php esc_html_e( '13', 'cbs-theme' ); ?></span>
				<span class="social-proof__stat-label"><?php esc_html_e( "ans d'expertise bien-être hôtelier", 'cbs-theme' ); ?></span>
			</li>
			<li class="social-proof__stat">
				<span class="social-proof__stat-value"><?php esc_html_e( 'FR', 'cbs-theme' ); ?></span>
				<span class="social-proof__stat-label"><?php esc_html_e( 'Alsace + France entière', 'cbs-theme' ); ?></span>
			</li>
		</ul>

		<div class="social-proof__logos">
			<p class="social-proof__logos-label" id="social-proof-logos-label"><?php esc_html_e( 'Ils nous font confiance', 'cbs-theme' ); ?></p>
			<ul class="social-proof__logo-list" role="list" aria-labelledby="social-proof-logos-label">
				<?php if ( ! empty( $logos ) ) : ?>
					<?php
					foreach ( $logos as $row ) {
						if ( ! is_array( $row ) ) {
							continue;
						}
						$img = isset( $row['cbs_logo_partenaire'] ) ? $row['cbs_logo_partenaire'] : null;
						$alt = isset( $row['cbs_logo_alt'] ) ? trim( (string) $row['cbs_logo_alt'] ) : '';

						$attachment_id = 0;
						if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
							$attachment_id = (int) $img['ID'];
						} elseif ( is_numeric( $img ) ) {
							$attachment_id = (int) $img;
						}

						if ( $attachment_id <= 0 ) {
							continue;
						}

						if ( $alt === '' ) {
							$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
							$alt = is_string( $alt ) ? trim( $alt ) : '';
						}
						if ( $alt === '' ) {
							$alt = __( 'Logo partenaire', 'cbs-theme' );
						}
						?>
						<li class="social-proof__logo-item">
							<?php
							echo wp_get_attachment_image(
								$attachment_id,
								'medium',
								false,
								[
									'class'   => 'social-proof__logo-img',
									'loading' => 'lazy',
									'decoding'=> 'async',
									'alt'     => $alt,
								]
							);
							?>
						</li>
						<?php
					}
					?>
				<?php else : ?>
					<?php
					for ( $i = 1; $i <= 5; $i++ ) {
						$label = sprintf(
							/* translators: %d: placeholder slot number (1–5) */
							__( 'Emplacement logo partenaire %d (à venir)', 'cbs-theme' ),
							$i
						);
						?>
						<li class="social-proof__logo-item">
							<span class="social-proof__logo-placeholder" role="img" aria-label="<?php echo esc_attr( $label ); ?>"></span>
						</li>
						<?php
					}
					?>
				<?php endif; ?>
			</ul>
		</div>

		<?php if ( ! empty( $temoignages ) ) : ?>
			<div class="social-proof__testimonials">
				<h3 class="social-proof__subheading"><?php esc_html_e( 'Témoignages', 'cbs-theme' ); ?></h3>
				<ul class="testimonial-list" role="list">
					<?php
					foreach ( $temoignages as $row ) {
						if ( ! is_array( $row ) ) {
							continue;
						}
						$texte         = isset( $row['cbs_temoignage_texte'] ) ? (string) $row['cbs_temoignage_texte'] : '';
						$auteur        = isset( $row['cbs_temoignage_auteur'] ) ? (string) $row['cbs_temoignage_auteur'] : '';
						$etablissement = isset( $row['cbs_temoignage_etablissement'] ) ? (string) $row['cbs_temoignage_etablissement'] : '';

						if ( $texte === '' ) {
							continue;
						}
						?>
						<li class="testimonial-list__item">
							<blockquote class="testimonial-card">
								<div class="testimonial-card__quote">
									<?php echo wp_kses_post( wpautop( $texte ) ); ?>
								</div>
								<?php if ( $auteur !== '' || $etablissement !== '' ) : ?>
									<footer class="testimonial-card__footer">
										<?php if ( $auteur !== '' ) : ?>
											<cite class="testimonial-card__author"><?php echo esc_html( $auteur ); ?></cite>
										<?php endif; ?>
										<?php if ( $etablissement !== '' ) : ?>
											<span class="testimonial-card__role"><?php echo esc_html( $etablissement ); ?></span>
										<?php endif; ?>
									</footer>
								<?php endif; ?>
							</blockquote>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</section>
