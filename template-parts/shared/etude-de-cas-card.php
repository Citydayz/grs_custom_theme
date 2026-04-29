<?php
/**
 * Carte cliquable — étude de cas (archive Références).
 *
 * @package CBS_Theme
 *
 * @param array<string, mixed> $args Arguments du template part (`post` => WP_Post).
 */

defined( 'ABSPATH' ) || exit;

$post = null;
if ( isset( $args['post'] ) && $args['post'] instanceof WP_Post ) {
	$post = $args['post'];
}
if ( ! $post ) {
	return;
}

$permalink = get_permalink( $post );
if ( ! $permalink ) {
	return;
}

$type_label = '';
$terms      = get_the_terms( $post, 'type-mission' );
if ( $terms && ! is_wp_error( $terms ) && isset( $terms[0] ) ) {
	$type_label = $terms[0]->name;
}

$contexte = function_exists( 'get_field' ) ? get_field( 'cbs_contexte', $post->ID ) : '';
$excerpt  = '';
if ( is_string( $contexte ) && $contexte !== '' ) {
	$excerpt = wp_trim_words( wp_strip_all_tags( $contexte ), 28, '…' );
} elseif ( has_excerpt( $post ) ) {
	$excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $post ) ), 28, '…' );
}

$heading_id = 'etude-card-title-' . (int) $post->ID;
?>
<article class="etude-cas-card" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<a class="etude-cas-card__link" href="<?php echo esc_url( $permalink ); ?>">
		<?php if ( $type_label !== '' ) : ?>
			<p class="etude-cas-card__type"><?php echo esc_html( $type_label ); ?></p>
		<?php endif; ?>
		<h2 class="etude-cas-card__title" id="<?php echo esc_attr( $heading_id ); ?>">
			<?php echo esc_html( get_the_title( $post ) ); ?>
		</h2>
		<?php if ( $excerpt !== '' ) : ?>
			<p class="etude-cas-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
		<?php endif; ?>
		<span class="etude-cas-card__cta btn-secondary">
			<?php esc_html_e( 'Voir l’étude', 'cbs-theme' ); ?>
		</span>
	</a>
</article>
