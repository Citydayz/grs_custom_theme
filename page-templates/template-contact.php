<?php
/**
 * Template Name: Contact
 *
 * Page contact — content-structure.md §10, integrations.md §2.
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

$calendly_base = '';
if ( defined( 'CBS_CALENDLY_URL' ) && CBS_CALENDLY_URL ) {
	$calendly_base = (string) CBS_CALENDLY_URL;
} elseif ( function_exists( 'cbs_get_calendly_inline_url' ) ) {
	$calendly_base = cbs_get_calendly_inline_url();
}
$has_calendly  = $calendly_base !== '';
$calendly_src  = $has_calendly
	? add_query_arg(
		array(
			'hide_gdpr_banner' => '1',
			'primary_color'    => 'c9a84c',
		),
		$calendly_base
	)
	: '';

$extra_class = $has_calendly ? '' : ' contact-page--form-only';

get_header();
?>
<main id="primary" class="site-main contact-page<?php echo esc_attr( $extra_class ); ?>">
	<section class="cbs-section methode-spa-hero contact-page__hero" aria-labelledby="contact-hero-heading">
		<div class="methode-spa-hero__inner cbs-container">
			<p class="methode-spa-hero__kicker contact-page__kicker"><?php esc_html_e( 'Contact', 'cbs-theme' ); ?></p>
			<h1 id="contact-hero-heading" class="methode-spa-hero__title">
				<?php esc_html_e( 'Parlons de votre projet', 'cbs-theme' ); ?>
			</h1>
			<p class="methode-spa-hero__subtitle">
				<?php esc_html_e( 'Je vous propose un premier échange de 30 minutes pour comprendre votre situation et voir comment je peux vous accompagner.', 'cbs-theme' ); ?>
			</p>
		</div>
	</section>

	<section class="cbs-section contact-page__body" aria-labelledby="contact-layout-heading">
		<h2 id="contact-layout-heading" class="screen-reader-text">
			<?php esc_html_e( 'Prise de rendez-vous et formulaire', 'cbs-theme' ); ?>
		</h2>
		<div class="cbs-container">
			<div class="contact-page__grid">
				<?php if ( $has_calendly ) : ?>
					<div class="contact-page__col contact-page__col--calendly">
						<p class="contact-page__col-title" id="contact-calendly-label">
							<?php esc_html_e( 'Prendre rendez-vous en ligne', 'cbs-theme' ); ?>
						</p>
						<div class="contact-page__calendly-card">
							<div
								class="calendly-inline-widget contact-page__calendly"
								data-url="<?php echo esc_url( $calendly_src ); ?>"
								role="region"
								aria-labelledby="contact-calendly-label"
							></div>
						</div>
					</div>
					<div class="contact-page__col-divider" aria-hidden="true"></div>
				<?php endif; ?>
				<div class="contact-page__col contact-page__col--form">
					<p class="contact-page__col-title" id="contact-form-label">
						<?php esc_html_e( 'Nous écrire', 'cbs-theme' ); ?>
					</p>
					<?php get_template_part( 'template-parts/shared/form-contact' ); ?>
				</div>
			</div>
		</div>
	</section>

	<section class="contact-page__seo-split" aria-labelledby="contact-seo-heading">
		<div class="cbs-container contact-page__seo-split-inner">
			<div class="contact-page__seo-text">
				<p class="contact-page__seo-kicker"><?php esc_html_e( 'Consultant spa hôtelier', 'cbs-theme' ); ?></p>
				<h2 id="contact-seo-heading" class="offre-detail__h2 contact-page__seo-heading"><?php esc_html_e( 'Un premier échange pour clarifier votre projet spa', 'cbs-theme' ); ?></h2>
				<p>
					<?php
					esc_html_e(
						'Chaque projet spa hôtelier est unique — qu\'il s\'agisse d\'une création, d\'une rénovation ou d\'une reprise en gestion. Ce premier échange de 30 minutes permet de cerner rapidement vos enjeux : niveau de gamme de l\'établissement, stade d\'avancement du projet, attentes en matière de rentabilité spa hôtelier. À l\'issue de cet appel, vous repartez avec une lecture claire de la situation et une première orientation sur le type d\'accompagnement adapté — sans engagement.',
						'cbs-theme'
					);
					?>
				</p>
			</div>
			<div class="contact-page__seo-img">
				<img
					src="<?php echo esc_url( 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=600&q=80' ); ?>"
					alt="<?php esc_attr_e( 'Spa hôtelier luxe — consultant Camille Becht', 'cbs-theme' ); ?>"
					width="600"
					height="400"
					loading="lazy"
					decoding="async"
				>
			</div>
		</div>
	</section>

	<section class="contact-page__reassurance" aria-label="<?php esc_attr_e( 'Pourquoi prendre rendez-vous', 'cbs-theme' ); ?>">
		<div class="cbs-container contact-page__reassurance-inner">
			<div class="contact-page__reassurance-grid">
				<div class="contact-page__reassurance-item">
					<div class="contact-page__reassurance-num" aria-hidden="true">01</div>
					<h3><?php esc_html_e( 'Un échange sans jargon', 'cbs-theme' ); ?></h3>
					<p>
						<?php
						esc_html_e(
							'Je parle le langage des directions hôtelières et des architectes — pas uniquement celui des praticiens spa. Chaque échange est calibré à votre contexte.',
							'cbs-theme'
						);
						?>
					</p>
				</div>
				<div class="contact-page__reassurance-item">
					<div class="contact-page__reassurance-num" aria-hidden="true">02</div>
					<h3><?php esc_html_e( 'Aucun engagement commercial', 'cbs-theme' ); ?></h3>
					<p>
						<?php
						esc_html_e(
							'Ce premier appel est un diagnostic, pas une proposition commerciale. L\'objectif est de vérifier ensemble si un accompagnement a du sens pour votre projet.',
							'cbs-theme'
						);
						?>
					</p>
				</div>
				<div class="contact-page__reassurance-item">
					<div class="contact-page__reassurance-num" aria-hidden="true">03</div>
					<h3><?php esc_html_e( '13 ans de terrain', 'cbs-theme' ); ?></h3>
					<p>
						<?php
						esc_html_e(
							'Projets de création, reprises, mise en performance — chaque situation a ses propres leviers. L\'expérience permet d\'aller à l\'essentiel dès le premier échange.',
							'cbs-theme'
						);
						?>
					</p>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
