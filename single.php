<?php
/**
 * CBS Theme — single.php — article (`post`).
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$thumb_url = '';
		if ( has_post_thumbnail() ) {
			$raw = get_the_post_thumbnail_url( null, 'full' );
			if ( is_string( $raw ) && $raw !== '' ) {
				$thumb_url = esc_url( $raw );
			}
		}

		$single_hero_classes = array(
			'cbs-section',
			'methode-spa-hero',
			'methode-spa-hero--compact',
			'single-article__hero',
		);
		if ( $thumb_url !== '' ) {
			$single_hero_classes[] = 'methode-spa-hero--photo-bg';
		}

		$cats_article = get_the_category();
		$primary_cat  = ( ! empty( $cats_article ) && is_array( $cats_article ) )
			? $cats_article[0]
			: null;

		$author_id     = (int) get_the_author_meta( 'ID' );
		$author_bio_us = trim( (string) get_the_author_meta( 'description' ) );

		$query_rel = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'post__not_in'        => array( (int) get_the_ID() ),
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'orderby'             => 'date',
				'order'               => 'DESC',
			)
		);

		$hero_bg_attr = '';
		if ( $thumb_url !== '' ) {
			$hero_bg_attr = sprintf(
				' style="background-image: url(%s);"',
				esc_url( $thumb_url )
			);
		}
		?>

		<article <?php post_class( 'single-article' ); ?>>
			<section
				class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $single_hero_classes ) ) ); ?>"
				aria-labelledby="single-article-heading"
				<?php echo $thumb_url !== '' ? $hero_bg_attr : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- attribut construit avec esc_url() ci‑dessus. ?>
			>
				<div class="methode-spa-hero__inner single-article__hero-inner cbs-container">
					<p class="single-article__hero-meta">
						<?php if ( $primary_cat instanceof WP_Term ) : ?>
							<span class="single-article__hero-cat"><?php echo esc_html( $primary_cat->name ); ?></span>
							<span class="single-article__hero-sep" aria-hidden="true"><?php esc_html_e( '·', 'cbs-theme' ); ?></span>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</p>
					<h1 id="single-article-heading" class="single-article__title"><?php the_title(); ?></h1>
				</div>
			</section>

			<div class="single-article__body-wrap">
				<div class="single-article__body">
					<?php the_content(); ?>
				</div>
			</div>

			<section class="single-article__author-strip" aria-label="<?php echo esc_attr__( 'À propos de l\'auteur', 'cbs-theme' ); ?>">
				<div class="single-article__author-inner">
					<?php if ( $author_bio_us !== '' ) : ?>
						<div class="single-article__author-block single-article__author-block--full">
							<?php
							echo wp_kses_post(
								get_avatar(
									$author_id,
									120,
									'',
									'',
									array(
										'class'    => 'single-article__author-photo',
										'loading'  => 'lazy',
										'decoding' => 'async',
									)
								)
							);
							?>
							<div class="single-article__author-text">
								<p class="single-article__author-name"><?php echo esc_html( get_the_author() ); ?></p>
								<p class="single-article__author-bio"><?php echo esc_html( $author_bio_us ); ?></p>
							</div>
						</div>
					<?php else : ?>
						<p class="single-article__author-fallback">
							<?php esc_html_e( 'Par Camille Becht', 'cbs-theme' ); ?>
						</p>
					<?php endif; ?>
				</div>
			</section>

			<?php
			$adjacent_prev = get_adjacent_post( false, '', true );
			$adjacent_next = get_adjacent_post( false, '', false );
			$single_pager_show_rule = ( $adjacent_prev instanceof WP_Post ) && ( $adjacent_next instanceof WP_Post );
			?>

			<nav class="single-article-pager" aria-label="<?php echo esc_attr__( 'Navigation entre articles', 'cbs-theme' ); ?>">
				<div class="single-article-pager__inner">
					<div class="single-article-pager__cell single-article-pager__cell--prev">
						<div class="single-article-pager__cell-slot">
							<?php
							previous_post_link(
								'%link',
								'<span class="single-article-pager__arrow" aria-hidden="true">←</span><span class="single-article-pager__kicker">' . esc_html__( 'Article précédent', 'cbs-theme' ) . '</span><span class="single-article-pager__post-title">%title</span>',
								false
							);
							?>
						</div>
					</div>
					<?php if ( $single_pager_show_rule ) : ?>
						<div class="single-article-pager__rule" aria-hidden="true"></div>
					<?php endif; ?>
					<div class="single-article-pager__cell single-article-pager__cell--next">
						<div class="single-article-pager__cell-slot">
							<?php
							next_post_link(
								'%link',
								'<span class="single-article-pager__arrow" aria-hidden="true">→</span><span class="single-article-pager__kicker">' . esc_html__( 'Article suivant', 'cbs-theme' ) . '</span><span class="single-article-pager__post-title">%title</span>',
								false
							);
							?>
						</div>
					</div>
				</div>
			</nav>

			<?php if ( $query_rel->have_posts() ) : ?>
				<section class="single-article__related" aria-labelledby="single-article-related-heading">
					<h2 id="single-article-related-heading" class="single-article__related-title">
						<?php esc_html_e( 'À lire aussi', 'cbs-theme' ); ?>
					</h2>
					<ul class="blog-grid single-article__related-grid">
						<?php
						while ( $query_rel->have_posts() ) :
							$query_rel->the_post();
							$cats_rel    = get_the_category();
							$r_cat       = ( ! empty( $cats_rel ) && is_array( $cats_rel ) ) ? $cats_rel[0] : null;
							$r_has_thumb = has_post_thumbnail();
							?>
						<li class="blog-grid__item">
							<article <?php post_class( 'blog-card' ); ?>>
								<div class="blog-card__thumb<?php echo esc_attr( $r_has_thumb ? '' : ' blog-card__thumb--empty' ); ?>">
									<?php if ( $r_has_thumb ) : ?>
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
										<?php if ( $r_cat instanceof WP_Term ) : ?>
											<span class="blog-card__cat"><?php echo esc_html( $r_cat->name ); ?></span>
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
						?>
					</ul>
				</section>
			<?php else : ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</article>

		<section class="cbs-section cta-rdv single-article__cta" aria-labelledby="single-post-cta-heading">
			<div class="cbs-container cta-rdv__inner">
				<h2 id="single-post-cta-heading" class="cta-rdv__title">
					<?php esc_html_e( 'Un projet spa hôtelier ? Parlons-en.', 'cbs-theme' ); ?>
				</h2>
				<a class="btn-primary cta-rdv__button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php esc_html_e( 'Prendre contact', 'cbs-theme' ); ?>
				</a>
			</div>
		</section>
		<?php
	endwhile;
endif;
?>
</main>
<?php
get_footer();
