<?php
/**
 * Page Qui sommes-nous (content-structure.md §9).
 *
 * ACF — groupe « CBS — Qui sommes-nous » : `cbs_bio`, repeaters chiffres / témoignages,
 * `cbs_qsn_valeurs`, bloc Académie.
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();

$bio          = '';
$chiffres     = array();
$valeurs      = '';
$acad_intro   = '';
$acad_url     = 'https://academie-rituels-spa.fr/';
$temoignages  = array();

if ( function_exists( 'get_field' ) ) {
	$bio_raw = get_field( 'cbs_bio', $pid );
	if ( is_string( $bio_raw ) ) {
		$bio = $bio_raw;
	}

	$ch_raw = get_field( 'cbs_qsn_chiffres', $pid );
	if ( is_array( $ch_raw ) ) {
		$chiffres = $ch_raw;
	}

	$val_raw = get_field( 'cbs_qsn_valeurs', $pid );
	if ( is_string( $val_raw ) ) {
		$valeurs = $val_raw;
	}

	$acad_intro_raw = get_field( 'cbs_qsn_academie_intro', $pid );
	if ( is_string( $acad_intro_raw ) ) {
		$acad_intro = $acad_intro_raw;
	}

	$acad_url_raw = get_field( 'cbs_qsn_academie_url', $pid );
	if ( is_string( $acad_url_raw ) && $acad_url_raw !== '' ) {
		$acad_url = $acad_url_raw;
	}

	$t_raw = get_field( 'cbs_qsn_temoignages', $pid );
	if ( is_array( $t_raw ) ) {
		$temoignages = $t_raw;
	}
}
?>
<section class="methode-spa-hero qui-sn-hero cbs-section" aria-labelledby="qui-sn-hero-heading">
	<div class="methode-spa-hero__inner cbs-container">
		<h1 id="qui-sn-hero-heading" class="methode-spa-hero__title">
			<?php esc_html_e( 'Notre expertise', 'cbs-theme' ); ?>
		</h1>
	</div>
</section>

<section class="cbs-section qui-sn-bio" aria-labelledby="qui-sn-bio-heading">
	<div class="cbs-container qui-sn-bio__inner">
		<h2 id="qui-sn-bio-heading" class="qui-sn-section-title">
			<?php esc_html_e( 'Présentation — Camille Becht', 'cbs-theme' ); ?>
		</h2>
		<div class="qui-sn-bio__content">
			<?php
			if ( is_string( $bio ) && trim( wp_strip_all_tags( $bio ) ) !== '' ) {
				echo wp_kses_post( $bio );
			} else {
				?>
				<p class="qui-sn-placeholder"><?php esc_html_e( '[À COMPLÉTER]', 'cbs-theme' ); ?></p>
				<?php
			}
			?>
		</div>
	</div>
</section>

<?php if ( ! empty( $chiffres ) ) : ?>
	<section class="cbs-section qui-sn-chiffres" aria-labelledby="qui-sn-chiffres-heading">
		<div class="cbs-container">
			<h2 id="qui-sn-chiffres-heading" class="screen-reader-text">
				<?php esc_html_e( 'Chiffres clés', 'cbs-theme' ); ?>
			</h2>
			<ul class="social-proof__stats qui-sn-chiffres__list" role="list">
				<?php
				foreach ( $chiffres as $row ) {
					if ( ! is_array( $row ) ) {
						continue;
					}
					$val   = isset( $row['cbs_qsn_chiffre_valeur'] ) ? trim( (string) $row['cbs_qsn_chiffre_valeur'] ) : '';
					$label = isset( $row['cbs_qsn_chiffre_libelle'] ) ? trim( (string) $row['cbs_qsn_chiffre_libelle'] ) : '';
					if ( $val === '' && $label === '' ) {
						continue;
					}
					?>
					<li class="social-proof__stat">
						<?php if ( $val !== '' ) : ?>
							<span class="social-proof__stat-value"><?php echo esc_html( $val ); ?></span>
						<?php endif; ?>
						<?php if ( $label !== '' ) : ?>
							<span class="social-proof__stat-label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<section class="cbs-section qui-sn-valeurs" aria-labelledby="qui-sn-valeurs-heading">
	<div class="cbs-container qui-sn-valeurs__inner">
		<h2 id="qui-sn-valeurs-heading" class="qui-sn-section-title">
			<?php esc_html_e( 'Valeurs et positionnement', 'cbs-theme' ); ?>
		</h2>
		<div class="qui-sn-valeurs__content">
			<?php
			if ( is_string( $valeurs ) && trim( wp_strip_all_tags( $valeurs ) ) !== '' ) {
				echo wp_kses_post( $valeurs );
			} else {
				?>
				<p class="qui-sn-placeholder"><?php esc_html_e( '[À COMPLÉTER]', 'cbs-theme' ); ?></p>
				<?php
			}
			?>
		</div>
	</div>
</section>

<section class="cbs-section qui-sn-academie" aria-labelledby="qui-sn-academie-heading">
	<div class="cbs-container">
		<div class="qui-sn-academie__card">
			<h2 id="qui-sn-academie-heading" class="qui-sn-academie__title">
				<?php esc_html_e( 'Écosystème & formation', 'cbs-theme' ); ?>
			</h2>
			<?php if ( is_string( $acad_intro ) && trim( wp_strip_all_tags( $acad_intro ) ) !== '' ) : ?>
				<div class="qui-sn-academie__intro">
					<?php echo wp_kses_post( $acad_intro ); ?>
				</div>
			<?php endif; ?>
			<p class="qui-sn-academie__cta-wrap">
				<a
					class="btn-secondary qui-sn-academie__link"
					href="<?php echo esc_url( $acad_url ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					<?php esc_html_e( 'Découvrir l’Académie des rituels spa', 'cbs-theme' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(ouvre un nouvel onglet)', 'cbs-theme' ); ?></span>
				</a>
			</p>
			<p class="qui-sn-academie__url-note">
				<?php esc_html_e( 'Site externe :', 'cbs-theme' ); ?>
				<span class="qui-sn-academie__host">academie-rituels-spa.fr</span>
			</p>
		</div>
	</div>
</section>

<?php if ( ! empty( $temoignages ) ) : ?>
	<section class="cbs-section qui-sn-temoignages social-proof" aria-labelledby="qui-sn-temoignages-heading">
		<div class="cbs-container">
			<h2 id="qui-sn-temoignages-heading" class="social-proof__title">
				<?php esc_html_e( 'Témoignages clients', 'cbs-theme' ); ?>
			</h2>
			<ul class="testimonial-list" role="list">
				<?php
				foreach ( $temoignages as $row ) {
					if ( ! is_array( $row ) ) {
						continue;
					}
					$texte         = isset( $row['cbs_qsn_temoignage_texte'] ) ? (string) $row['cbs_qsn_temoignage_texte'] : '';
					$auteur        = isset( $row['cbs_qsn_temoignage_auteur'] ) ? (string) $row['cbs_qsn_temoignage_auteur'] : '';
					$etablissement = isset( $row['cbs_qsn_temoignage_etablissement'] ) ? (string) $row['cbs_qsn_temoignage_etablissement'] : '';

					if ( trim( $texte ) === '' ) {
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
	</section>
<?php endif; ?>

<section class="cbs-section qui-sn-final-cta cta-rdv" aria-labelledby="qui-sn-cta-heading">
	<div class="cbs-container cta-rdv__inner">
		<h2 id="qui-sn-cta-heading" class="screen-reader-text">
			<?php esc_html_e( 'Contact', 'cbs-theme' ); ?>
		</h2>
		<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
			<?php esc_html_e( 'Nous contacter', 'cbs-theme' ); ?>
		</a>
	</div>
</section>
