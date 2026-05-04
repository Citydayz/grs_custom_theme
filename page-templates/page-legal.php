<?php
/**
 * Template Name: Page légale
 *
 * Mise en page CGU, mentions légales, politique de confidentialité (éditeur classique).
 *
 * @package CBS_Theme
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main legal-page">
	<?php
	while ( have_posts() ) {
		the_post();
		$post_id   = get_the_ID();
		$prepared  = cbs_legal_prepare_content( (string) get_post_field( 'post_content', $post_id ) );
		$headings  = $prepared['headings'];
		$show_toc  = count( $headings ) > 5;
		$updated   = cbs_legal_get_last_updated_display( $post_id );
		?>
		<section class="methode-spa-hero methode-spa-hero--compact legal-page__hero" aria-labelledby="legal-page-title">
			<div class="methode-spa-hero__inner cbs-container">
				<p class="methode-spa-hero__kicker"><?php esc_html_e( 'Document légal', 'cbs-theme' ); ?></p>
				<h1 id="legal-page-title" class="methode-spa-hero__title"><?php the_title(); ?></h1>
				<p class="methode-spa-hero__subtitle legal-page__hero-meta">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: date (d/m/Y) */
							__( 'Dernière mise à jour : %s', 'cbs-theme' ),
							$updated
						)
					);
					?>
				</p>
			</div>
		</section>

		<section class="cbs-section legal-page__section" aria-label="<?php esc_attr_e( 'Contenu', 'cbs-theme' ); ?>">
			<div class="cbs-container">
				<div class="legal-page__inner">
					<?php if ( $show_toc ) : ?>
						<details class="legal-page__toc" id="legal-page-toc" open>
							<summary class="legal-page__toc-summary">
								<?php esc_html_e( 'Table des matières', 'cbs-theme' ); ?>
							</summary>
							<nav class="legal-page__toc-nav" aria-label="<?php esc_attr_e( 'Sections de la page', 'cbs-theme' ); ?>">
								<ol class="legal-page__toc-list">
									<?php foreach ( $headings as $item ) : ?>
										<li>
											<a href="<?php echo esc_url( '#' . $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
										</li>
									<?php endforeach; ?>
								</ol>
							</nav>
						</details>
					<?php endif; ?>

					<div class="legal-page__prose entry-content">
						<?php echo $prepared['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already filtered by the_content. ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
	?>
</main>
<script>
(function () {
	var toc = document.getElementById('legal-page-toc');
	if (!toc || !window.matchMedia) return;
	var mq = window.matchMedia('(max-width: 767px)');
	function apply() {
		if (mq.matches) toc.removeAttribute('open');
		else toc.setAttribute('open', '');
	}
	apply();
	if (mq.addEventListener) mq.addEventListener('change', apply);
	else if (mq.addListener) mq.addListener(apply);
})();
</script>
<?php
get_footer();
