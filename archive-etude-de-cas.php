<?php
/**
 * Archive CPT études de cas — `/etudes-de-cas/` ; vitrine `/references/` (page).
 *
 * @package CBS_Theme
 */

defined( 'ABSPATH' ) || exit;

$filter_slug = isset( $_GET['type_mission'] ) ? sanitize_title( wp_unslash( (string) $_GET['type_mission'] ) ) : '';
$filter_term = null;
if ( $filter_slug !== '' ) {
	$t = get_term_by( 'slug', $filter_slug, 'type-mission' );
	if ( $t && ! is_wp_error( $t ) ) {
		$filter_term = $t;
	}
}

$mission_terms = get_terms(
	array(
		'taxonomy'   => 'type-mission',
		'hide_empty' => false,
	)
);
$show_filter = ! is_wp_error( $mission_terms ) && is_array( $mission_terms ) && count( $mission_terms ) > 0;

$paged = (int) get_query_var( 'paged' );
if ( $paged < 1 ) {
	$paged = 1;
}

$query_args = array(
	'post_type'      => 'etude-de-cas',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'paged'          => $paged,
	'no_found_rows'  => false,
);

if ( $filter_term instanceof WP_Term ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'type-mission',
			'field'    => 'slug',
			'terms'    => $filter_term->slug,
		),
	);
}

$etudes_query = new WP_Query( $query_args );

get_header();
?>
<main id="primary" class="site-main references-page">
	<section class="cbs-section references-page__hero" aria-labelledby="references-hero-heading">
		<div class="references-page__hero-inner cbs-container">
			<h1 id="references-hero-heading" class="references-page__title">
				<?php esc_html_e( 'Références & Études de cas', 'cbs-theme' ); ?>
			</h1>
			<p class="references-page__lead">
				<?php esc_html_e( 'Des projets spa accompagnés dans l’hôtellerie haut de gamme', 'cbs-theme' ); ?>
			</p>
			<p class="references-page__intro">
				<?php esc_html_e( 'Chaque établissement a ses spécificités. Voici quelques exemples de missions de conseil et de gestion menées par Camille Becht.', 'cbs-theme' ); ?>
			</p>
			<ul class="references-page__stats" aria-label="<?php esc_attr_e( 'Chiffres clés', 'cbs-theme' ); ?>">
				<li><?php esc_html_e( '+10 hôtels 4★ accompagnés', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Hôtels 5★ et groupes hôteliers', 'cbs-theme' ); ?></li>
				<li><?php esc_html_e( 'Missions de conseil + contrats de gestion', 'cbs-theme' ); ?></li>
			</ul>
		</div>
	</section>

	<section class="cbs-section references-page__body" aria-labelledby="references-list-heading">
		<div class="cbs-container">
			<h2 id="references-list-heading" class="screen-reader-text">
				<?php esc_html_e( 'Liste des études de cas', 'cbs-theme' ); ?>
			</h2>

			<?php if ( $show_filter ) : ?>
				<form class="references-page__filter" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'etude-de-cas' ) ); ?>">
					<label class="references-page__filter-label" for="references-type-mission">
						<?php esc_html_e( 'Filtrer par type de mission', 'cbs-theme' ); ?>
					</label>
					<div class="references-page__filter-row">
						<select class="references-page__filter-select form__select" name="type_mission" id="references-type-mission">
							<option value=""><?php esc_html_e( 'Tous les types', 'cbs-theme' ); ?></option>
							<?php foreach ( $mission_terms as $term ) : ?>
								<option value="<?php echo esc_attr( $term->slug ); ?>"<?php selected( $filter_slug, $term->slug ); ?>>
									<?php echo esc_html( $term->name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<button type="submit" class="btn-primary references-page__filter-submit">
							<?php esc_html_e( 'Filtrer', 'cbs-theme' ); ?>
						</button>
					</div>
				</form>
			<?php endif; ?>

			<?php if ( $etudes_query->have_posts() ) : ?>
				<div class="references-page__grid">
					<?php
					while ( $etudes_query->have_posts() ) {
						$etudes_query->the_post();
						get_template_part( 'template-parts/shared/etude-de-cas-card', null, array( 'post' => get_post() ) );
					}
					wp_reset_postdata();
					?>
				</div>

				<?php if ( $etudes_query->max_num_pages > 1 ) : ?>
					<nav class="references-page__pagination" aria-label="<?php esc_attr_e( 'Pagination des études de cas', 'cbs-theme' ); ?>">
						<?php
						$big  = 999999999;
						$base = str_replace( (string) $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
						echo paginate_links(
							array(
								'base'      => $base,
								'format'    => '',
								'current'   => $paged,
								'total'     => $etudes_query->max_num_pages,
								'type'      => 'list',
								'prev_text' => __( 'Précédent', 'cbs-theme' ),
								'next_text' => __( 'Suivant', 'cbs-theme' ),
								'add_args'  => $filter_slug ? array( 'type_mission' => $filter_slug ) : array(),
							)
						);
						?>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<div class="references-page__empty" role="status">
					<p class="references-page__empty-text">
						<?php esc_html_e( 'Aucune étude de cas n’est publiée pour le moment. Revenez bientôt ou contactez-nous pour échanger sur votre projet.', 'cbs-theme' ); ?>
					</p>
					<a class="btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
						<?php esc_html_e( 'Nous contacter', 'cbs-theme' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
