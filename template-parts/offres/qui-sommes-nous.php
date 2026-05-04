<?php
/**
 * Page Qui sommes-nous (content-structure.md §9).
 *
 * ACF — groupe « CBS — Qui sommes-nous » : `cbs_qsn_photo`, `cbs_qsn_bio`, `cbs_qsn_chiffres`,
 * `cbs_qsn_valeurs` (repeater), `cbs_qsn_academie_image`, `cbs_qsn_academie_url`, `cbs_qsn_temoignages`.
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

while ( have_posts() ) {
	the_post();
}

$pid = (int) get_the_ID();

$bio_html       = '';
$chiffres       = array();
$valeurs_rows   = array();
$acad_url       = 'https://academie-rituels-spa.fr/';
$temoignages    = array();
$bio_photo_acf  = null;
$acad_image_acf = null;

if ( function_exists( 'get_field' ) ) {
	$bio_photo_acf = get_field( 'cbs_qsn_photo', $pid );
	$bio_raw       = get_field( 'cbs_qsn_bio', $pid );
	if ( is_string( $bio_raw ) && trim( wp_strip_all_tags( $bio_raw ) ) !== '' ) {
		$bio_html = $bio_raw;
	}

	$ch_raw = get_field( 'cbs_qsn_chiffres', $pid );
	if ( is_array( $ch_raw ) ) {
		foreach ( $ch_raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$val   = isset( $row['cbs_qsn_chiffre_valeur'] ) ? trim( (string) $row['cbs_qsn_chiffre_valeur'] ) : '';
			$label = isset( $row['cbs_qsn_chiffre_libelle'] ) ? trim( (string) $row['cbs_qsn_chiffre_libelle'] ) : '';
			if ( $val === '' && $label === '' ) {
				continue;
			}
			$chiffres[] = array(
				'cbs_qsn_chiffre_valeur'  => $val,
				'cbs_qsn_chiffre_libelle' => $label,
			);
		}
	}

	$val_rep = get_field( 'cbs_qsn_valeurs', $pid );
	if ( is_array( $val_rep ) ) {
		foreach ( $val_rep as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$titre = isset( $row['cbs_qsn_valeur_titre'] ) ? trim( (string) $row['cbs_qsn_valeur_titre'] ) : '';
			$texte = isset( $row['cbs_qsn_valeur_texte'] ) ? trim( (string) $row['cbs_qsn_valeur_texte'] ) : '';
			if ( $titre === '' && $texte === '' ) {
				continue;
			}
			$valeurs_rows[] = array(
				'cbs_qsn_valeur_titre' => $titre,
				'cbs_qsn_valeur_texte' => $texte,
			);
		}
	}

	$acad_image_acf = get_field( 'cbs_qsn_academie_image', $pid );

	$acad_url_raw = get_field( 'cbs_qsn_academie_url', $pid );
	if ( is_string( $acad_url_raw ) && $acad_url_raw !== '' ) {
		$acad_url = $acad_url_raw;
	}

	$t_raw = get_field( 'cbs_qsn_temoignages', $pid );
	if ( is_array( $t_raw ) ) {
		$temoignages = $t_raw;
	}
}

if ( $chiffres === array() ) {
	$chiffres = cbs_qsn_default_chiffres();
}

if ( $valeurs_rows === array() ) {
	$valeurs_rows = cbs_qsn_default_valeurs();
}

if ( $bio_html === '' ) {
	$bio_html = cbs_qsn_default_bio_html();
}

$bio_img_src = cbs_qsn_image_src( $bio_photo_acf, cbs_qsn_placeholder_bio_image() );
$bio_img_alt = cbs_qsn_image_alt( $bio_photo_acf, __( 'Camille Becht', 'cbs-theme' ) );

$acad_img_src = cbs_qsn_image_src( $acad_image_acf, cbs_qsn_placeholder_academie_image() );
$acad_img_alt = cbs_qsn_image_alt( $acad_image_acf, __( 'Univers spa et rituels bien-être', 'cbs-theme' ) );

$acad_intro_html = cbs_qsn_default_academie_intro_html();

$hero_bg = '';
if ( has_post_thumbnail() ) {
	$thumb_url = get_the_post_thumbnail_url( null, 'full' );
	if ( is_string( $thumb_url ) && $thumb_url !== '' ) {
		$hero_bg = ' style="background-image: url(\'' . esc_url( $thumb_url ) . '\');"';
	}
}
?>
<div class="qui-sommes-nous">
	<section class="methode-spa-hero qui-sn-hero qui-sommes-nous__hero cbs-section" aria-labelledby="qui-sommes-nous-hero-heading"<?php echo $hero_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_url(). ?>>
		<div class="methode-spa-hero__inner cbs-container">
			<h1 id="qui-sommes-nous-hero-heading" class="methode-spa-hero__title">
				<?php esc_html_e( 'De l’art du geste à l’art d’accompagner', 'cbs-theme' ); ?>
			</h1>
			<p class="methode-spa-hero__subtitle">
				<?php esc_html_e( '13 ans d’expertise terrain au service des hôtels 4 et 5 étoiles.', 'cbs-theme' ); ?>
			</p>
		</div>
	</section>

	<section class="qui-sommes-nous__bio cbs-section" aria-labelledby="qui-sommes-nous-bio-heading">
		<div class="qui-sommes-nous__bio-split">
			<div class="qui-sommes-nous__bio-media">
				<img
					src="<?php echo esc_url( $bio_img_src ); ?>"
					alt="<?php echo esc_attr( $bio_img_alt ); ?>"
					width="800"
					height="1000"
					loading="lazy"
					decoding="async"
				/>
			</div>
			<div class="qui-sommes-nous__bio-text">
				<p class="qui-sommes-nous__kicker"><?php esc_html_e( 'CAMILLE BECHT', 'cbs-theme' ); ?></p>
				<h2 id="qui-sommes-nous-bio-heading" class="qui-sommes-nous__bio-heading">
					<?php esc_html_e( 'Une expertise née du terrain', 'cbs-theme' ); ?>
				</h2>
				<div class="qui-sommes-nous__bio-copy">
					<?php echo wp_kses_post( $bio_html ); ?>
				</div>
			</div>
		</div>
	</section>

	<section class="qui-sommes-nous__stats-strip cbs-section" aria-labelledby="qui-sommes-nous-stats-heading">
		<div class="cbs-container">
			<h2 id="qui-sommes-nous-stats-heading" class="screen-reader-text">
				<?php esc_html_e( 'Chiffres clés', 'cbs-theme' ); ?>
			</h2>
			<ul class="qui-sommes-nous__stats-list" role="list">
				<?php
				foreach ( $chiffres as $row ) {
					$val   = isset( $row['cbs_qsn_chiffre_valeur'] ) ? trim( (string) $row['cbs_qsn_chiffre_valeur'] ) : '';
					$label = isset( $row['cbs_qsn_chiffre_libelle'] ) ? trim( (string) $row['cbs_qsn_chiffre_libelle'] ) : '';
					if ( $val === '' && $label === '' ) {
						continue;
					}
					?>
					<li class="qui-sommes-nous__stats-item">
						<?php if ( $val !== '' ) : ?>
							<p class="qui-sommes-nous__stats-value"><?php echo esc_html( $val ); ?></p>
						<?php endif; ?>
						<?php if ( $label !== '' ) : ?>
							<p class="qui-sommes-nous__stats-label"><?php echo esc_html( $label ); ?></p>
						<?php endif; ?>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</section>

	<section class="qui-sommes-nous__valeurs cbs-section" aria-labelledby="qui-sommes-nous-valeurs-heading">
		<div class="cbs-container">
			<h2 id="qui-sommes-nous-valeurs-heading" class="screen-reader-text">
				<?php esc_html_e( 'Nos valeurs', 'cbs-theme' ); ?>
			</h2>
			<div class="qui-sommes-nous__valeurs-grid" role="list">
				<?php
				foreach ( $valeurs_rows as $row ) {
					$titre = isset( $row['cbs_qsn_valeur_titre'] ) ? (string) $row['cbs_qsn_valeur_titre'] : '';
					$texte = isset( $row['cbs_qsn_valeur_texte'] ) ? (string) $row['cbs_qsn_valeur_texte'] : '';
					if ( $titre === '' && trim( wp_strip_all_tags( $texte ) ) === '' ) {
						continue;
					}
					?>
					<div class="qui-sommes-nous__valeurs-col" role="listitem">
						<?php if ( $titre !== '' ) : ?>
							<h3 class="qui-sommes-nous__valeur-title"><?php echo esc_html( $titre ); ?></h3>
						<?php endif; ?>
						<?php if ( $texte !== '' ) : ?>
							<div class="qui-sommes-nous__valeur-text">
								<?php echo wp_kses_post( wpautop( $texte ) ); ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</section>

	<section class="qui-sommes-nous__academie cbs-section" aria-labelledby="qui-sommes-nous-academie-heading">
		<div class="qui-sommes-nous__academie-split">
			<div class="qui-sommes-nous__academie-text">
				<p class="qui-sommes-nous__kicker"><?php esc_html_e( 'ÉCOSYSTÈME', 'cbs-theme' ); ?></p>
				<h2 id="qui-sommes-nous-academie-heading" class="qui-sommes-nous__academie-heading">
					<?php esc_html_e( 'La Maison Camille Becht', 'cbs-theme' ); ?>
				</h2>
				<div class="qui-sommes-nous__academie-copy">
					<?php echo wp_kses_post( $acad_intro_html ); ?>
				</div>
				<p class="qui-sommes-nous__academie-cta">
					<a
						class="btn-secondary"
						href="<?php echo esc_url( $acad_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<?php esc_html_e( 'Découvrir l’Académie', 'cbs-theme' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(ouvre un nouvel onglet)', 'cbs-theme' ); ?></span>
					</a>
				</p>
			</div>
			<div class="qui-sommes-nous__academie-media">
				<img
					src="<?php echo esc_url( $acad_img_src ); ?>"
					alt="<?php echo esc_attr( $acad_img_alt ); ?>"
					width="800"
					height="600"
					loading="lazy"
					decoding="async"
				/>
			</div>
		</div>
	</section>

	<?php if ( ! empty( $temoignages ) ) : ?>
		<section class="qui-sommes-nous__testimonials cbs-section social-proof" aria-labelledby="qui-sommes-nous-temoignages-heading">
			<div class="cbs-container">
				<h2 id="qui-sommes-nous-temoignages-heading" class="social-proof__title">
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

	<section class="qui-sommes-nous__final-cta cbs-section cta-rdv" aria-labelledby="qui-sommes-nous-cta-heading">
		<div class="cbs-container cta-rdv__inner">
			<h2 id="qui-sommes-nous-cta-heading" class="screen-reader-text">
				<?php esc_html_e( 'Contact', 'cbs-theme' ); ?>
			</h2>
			<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Nous contacter', 'cbs-theme' ); ?>
			</a>
		</div>
	</section>
</div>
