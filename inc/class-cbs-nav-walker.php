<?php
/**
 * Walker du menu principal — structure navigation.md §4.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'CBS_Nav_Walker', false ) ) {

	/**
	 * @package CBS_Theme
	 */
	class CBS_Nav_Walker extends Walker_Nav_Menu {

		/**
		 * @var string
		 */
		private $current_submenu_id = '';

		/**
		 * @param string   $output Liste HTML.
		 * @param int      $depth  Profondeur.
		 * @param stdClass $args   Arguments du menu.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( 0 !== (int) $depth ) {
				return;
			}
			$id_attr = '';
			if ( '' !== $this->current_submenu_id ) {
				$id_attr = ' id="' . esc_attr( $this->current_submenu_id ) . '"';
			}
			$output .= "\n<ul{$id_attr} class=\"nav__dropdown\" role=\"list\" hidden>\n";
		}

		/**
		 * @param string   $output Liste HTML.
		 * @param int      $depth  Profondeur.
		 * @param stdClass $args   Arguments du menu.
		 */
		public function end_lvl( &$output, $depth = 0, $args = null ) {
			if ( 0 !== (int) $depth ) {
				return;
			}
			$output .= "</ul>\n";
		}

		/**
		 * @param string   $output Liste HTML.
		 * @param WP_Post  $item   Entrée de menu.
		 * @param int      $depth  Profondeur.
		 * @param stdClass $args   Arguments du menu.
		 * @param int      $id     ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
			$has_children = in_array( 'menu-item-has-children', $classes, true );
			$depth        = (int) $depth;

			if ( 0 === $depth ) {
				$li_class = 'nav__item';
				if ( $has_children ) {
					$li_class .= ' nav__item--has-children';
				}
				$output .= '<li class="' . esc_attr( $li_class ) . '">';

				if ( $has_children ) {
					$this->current_submenu_id = 'nav-submenu-' . (int) $item->ID;
					$title                      = apply_filters( 'the_title', $item->title, $item->ID );
					$title_plain                = wp_strip_all_tags( (string) $title );
					$chevron                    = '<svg class="nav__chevron" aria-hidden="true" width="12" height="8" viewBox="0 0 12 8" focusable="false"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>';
					$toggle_label               = sprintf(
						/* translators: %s: menu item title */
						__( 'Ouvrir le sous-menu : %s', 'cbs-theme' ),
						$title_plain
					);
					$output .= '<div class="nav__parent-row">';
					$output .= '<a class="nav__link nav__link--parent" href="' . esc_url( $item->url ) . '"' . $this->cbs_aria_current( $classes ) . '>';
					$output .= esc_html( $title_plain );
					$output .= '</a>';
					$output .= '<button type="button" class="nav__submenu-toggle" aria-expanded="false" aria-haspopup="true" aria-controls="' . esc_attr( $this->current_submenu_id ) . '" aria-label="' . esc_attr( $toggle_label ) . '">';
					$output .= $chevron;
					$output .= '</button>';
					$output .= '</div>';
				} else {
					$this->current_submenu_id = '';
					$output .= '<a class="nav__link" href="' . esc_url( $item->url ) . '"' . $this->cbs_aria_current( $classes ) . '>';
					$output .= esc_html( wp_strip_all_tags( (string) $item->title ) );
					$output .= '</a>';
				}
			} elseif ( 1 === $depth ) {
				$output .= '<li class="nav__dropdown-item">';
				$output .= '<a class="nav__dropdown-link" href="' . esc_url( $item->url ) . '">';
				$output .= esc_html( wp_strip_all_tags( (string) $item->title ) );
				$output .= '</a>';
			}
		}

		/**
		 * @param string   $output Liste HTML.
		 * @param WP_Post  $item   Entrée de menu.
		 * @param int      $depth  Profondeur.
		 * @param stdClass $args   Arguments du menu.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			$depth = (int) $depth;
			if ( 0 === $depth || 1 === $depth ) {
				$output .= "</li>\n";
			}
		}

		/**
		 * @param array<string> $classes Classes WP du lien.
		 */
		private function cbs_aria_current( array $classes ): string {
			if ( in_array( 'current-menu-item', $classes, true ) ) {
				return ' aria-current="page"';
			}
			return '';
		}
	}
}
