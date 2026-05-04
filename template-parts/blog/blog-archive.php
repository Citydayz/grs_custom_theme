<?php
/**
 * CBS Theme — listing articles (home + archive category/tag/author/date).
 */
defined( 'ABSPATH' ) || exit;

$paged            = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$total_grid_pages = cbs_blog_archive_total_grid_pages();
$posts_total      = cbs_blog_archive_matching_count();
$base_args        = cbs_blog_archive_base_query_args();

$show_featured = $posts_total > 0 && $paged === 1;

$featured_query = null;
if ( $show_featured ) {
	$featured_query = new WP_Query(
		array_merge(
			$base_args,
			array(
				'posts_per_page' => 1,
				'no_found_rows'  => true,
			)
		)
	);
}

$grid_offset = ( $paged === 1 )
	? 1
	: ( 1 + ( 6 * ( $paged - 1 ) ) );

$grid_query = null;
if ( $posts_total > ( $show_featured ? 1 : 0 ) ) {
	$grid_query = new WP_Query(
		array_merge(
			$base_args,
			array(
				'posts_per_page' => 6,
				'offset'          => max( 0, $grid_offset ),
				'no_found_rows'   => true,
			)
		)
	);
}

$paginate_big = 999999999;
?>
<div class="blog-archive">

	<section class="cbs-section methode-spa-hero blog-archive__hero cbs-blog-hero" aria-labelledby="blog-archive-heading">
		<div class="methode-spa-hero__inner cbs-container">
			<p class="methode-spa-hero__kicker"><?php esc_html_e( 'BLOG', 'cbs-theme' ); ?></p>
			<h1 id="blog-archive-heading" class="methode-spa-hero__title"><?php esc_html_e( 'Réflexions & ressources spa hôtelier', 'cbs-theme' ); ?></h1>
			<p class="methode-spa-hero__subtitle">
				<?php esc_html_e( 'Conseils, tendances et retours d\'expérience pour les professionnels du spa hôtelier haut de gamme.', 'cbs-theme' ); ?>
			</p>
		</div>
	</section>

	<?php if ( null !== $featured_query && $featured_query->have_posts() ) : ?>
		<?php
		while ( $featured_query->have_posts() ) :
			$featured_query->the_post();
			$cats           = get_the_category();
			$primary_cat    = ( ! empty( $cats ) && is_array( $cats ) ) ? $cats[0] : null;
			$has_thumb_feat = has_post_thumbnail();
			?>
	<section class="blog-featured" aria-labelledby="blog-featured-title">
			<div class="blog-featured__grid<?php echo esc_attr( $has_thumb_feat ? '' : ' blog-featured__grid--no-thumb' ); ?>">
				<div class="blog-featured__visual">
					<?php if ( $has_thumb_feat ) : ?>
						<div class="blog-featured__img-wrap">
							<?php
							the_post_thumbnail(
								'large',
								array(
									'class'          => 'blog-featured__img',
									'loading'        => 'eager',
									'fetchpriority'  => 'high',
									'decoding'       => 'async',
								)
							);
							?>
						</div>
					<?php else : ?>
						<div class="blog-featured__placeholder">
							<svg class="blog-featured__placeholder-icon" width="96" height="96" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" aria-hidden="true" focusable="false">
								<path fill="currentColor" fill-opacity="0.35" d="M12 52V20l20 12 20-12v32H12Zm4-26.3V46h36V27.9L32 36.9 16 25.7Z" />
							</svg>
						</div>
					<?php endif; ?>
				</div>
				<div class="blog-featured__content">
					<p class="blog-featured__meta">
						<?php if ( $primary_cat instanceof WP_Term ) : ?>
							<span class="blog-featured__cat"><?php echo esc_html( $primary_cat->name ); ?></span>
							<span class="blog-featured__sep">·</span>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</p>
					<h2 id="blog-featured-title" class="blog-featured__title"><?php the_title(); ?></h2>
					<p class="blog-featured__excerpt">
						<?php echo esc_html( wp_trim_words( get_the_excerpt(), 120 ) ); ?>
					</p>
					<a class="btn-secondary blog-featured__link" href="<?php echo esc_url( get_permalink() ); ?>">
						<?php esc_html_e( 'Lire l\'article', 'cbs-theme' ); ?>
					</a>
				</div>
			</div>
	</section>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<?php if ( $posts_total > 0 ) : ?>
		<section class="blog-archive__grid-wrap" aria-label="<?php esc_attr_e( 'Articles', 'cbs-theme' ); ?>">
			<ul class="blog-grid">
				<?php
				if ( null !== $grid_query && $grid_query->have_posts() ) :
					while ( $grid_query->have_posts() ) :
						$grid_query->the_post();
						$cats_grid    = get_the_category();
						$p_cat        = ( ! empty( $cats_grid ) && is_array( $cats_grid ) ) ? $cats_grid[0] : null;
						$thumb_exists = has_post_thumbnail();
						?>
				<li class="blog-grid__item">
					<article <?php post_class( 'blog-card' ); ?>>
						<div class="blog-card__thumb<?php echo esc_attr( $thumb_exists ? '' : ' blog-card__thumb--empty' ); ?>">
							<?php if ( $thumb_exists ) : ?>
								<a class="blog-card__thumb-link" href="<?php echo esc_url( get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
									<?php
									the_post_thumbnail(
										'medium_large',
										array(
											'class'    => 'blog-card__img',
											'loading'  => 'lazy',
											'decoding' => 'async',
										)
									);
									?>
								</a>
							<?php endif; ?>
						</div>
						<div class="blog-card__body">
							<p class="blog-card__meta">
								<?php if ( $p_cat instanceof WP_Term ) : ?>
									<span class="blog-card__cat"><?php echo esc_html( $p_cat->name ); ?></span>
									<span class="blog-card__sep">·</span>
								<?php endif; ?>
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
							</p>
							<h3 class="blog-card__title">
								<a class="blog-card__title-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 60 ) ); ?></p>
							<a class="blog-card__read" href="<?php echo esc_url( get_permalink() ); ?>">
								<?php esc_html_e( 'Lire', 'cbs-theme' ); ?> <span class="blog-card__read-arrow" aria-hidden="true">→</span>
							</a>
						</div>
					</article>
				</li>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</ul>
		</section>
	<?php else : ?>
		<section class="blog-archive__empty-wrap cbs-section">
			<p class="cbs-container blog-archive__empty"><?php esc_html_e( 'Aucun article pour le moment.', 'cbs-theme' ); ?></p>
		</section>
	<?php endif; ?>

	<?php if ( $total_grid_pages > 1 ) : ?>
		<nav class="blog-pagination" aria-label="<?php esc_attr_e( 'Pagination des articles', 'cbs-theme' ); ?>">
			<?php
			$pagination = paginate_links(
				array(
					'type'               => 'list',
					'base'               => str_replace( (string) $paginate_big, '%#%', esc_url( get_pagenum_link( $paginate_big ) ) ),
					'total'              => $total_grid_pages,
					'current'            => $paged,
					'mid_size'           => 2,
					'end_size'           => 1,
					'prev_text'          => '<span class="blog-pagination__arrow blog-pagination__arrow--prev"><span aria-hidden="true">&larr;</span><span class="screen-reader-text">' . esc_html__( 'Page précédente', 'cbs-theme' ) . '</span></span>',
					'next_text'          => '<span class="blog-pagination__arrow blog-pagination__arrow--next"><span aria-hidden="true">&rarr;</span><span class="screen-reader-text">' . esc_html__( 'Page suivante', 'cbs-theme' ) . '</span></span>',
					'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page ', 'cbs-theme' ) . '</span>',
				)
			);

			echo is_string( $pagination ) ? wp_kses_post( $pagination ) : '';
			?>
		</nav>
	<?php endif; ?>

	<section class="cbs-section cta-rdv blog-archive__cta" aria-labelledby="blog-archive-cta-heading">
		<div class="cbs-container cta-rdv__inner">
			<h2 id="blog-archive-cta-heading" class="cta-rdv__title">
				<?php esc_html_e( 'Un projet spa hôtelier ? Parlons-en.', 'cbs-theme' ); ?>
			</h2>
			<a class="btn-primary cta-rdv__button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<?php esc_html_e( 'Prendre contact', 'cbs-theme' ); ?>
			</a>
		</div>
	</section>

</div>
