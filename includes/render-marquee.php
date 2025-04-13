<?php

add_action( 'wp_footer', 'mk_simple_marquee_frontend_display' );

function mk_simple_marquee_frontend_display() {
	$options = get_option( 'mk_simple_marquee_options' );

	if ( isset( $options['enable'] ) && $options['enable'] == 1 ) {
		$bg_color = isset( $options['bg_color'] ) ? esc_attr( $options['bg_color'] ) : '#000000';
		$text_color = isset( $options['text_color'] ) ? esc_attr( $options['text_color'] ) : '#ffffff';
		$font_size = isset( $options['font_size'] ) ? esc_attr( $options['font_size'] ) : '16px';
		$speed = isset( $options['speed'] ) ? esc_attr( $options['speed'] ) : '40s';
		$height = isset( $options['height'] ) ? esc_attr( $options['height'] ) : '40px';
		$position = isset( $options['position'] ) ? esc_attr( $options['position'] ) : 'bottom';
		$disable_on_mobile = isset( $options['disable_on_mobile'] ) ? esc_attr( $options['disable_on_mobile'] ) : 'off-mobile';
		$hover_pause = isset( $options['hover_pause'] ) ? esc_attr( $options['hover_pause'] ) : 'true';

		$source = isset( $options['source'] ) ? esc_attr( $options['source'] ) : 'posts';

		$posts_per_page = get_option( 'posts_per_page' );

		$posts = get_posts( [ 'numberposts' => $posts_per_page ] );

		$marquee_content = '';
		if ( $source === 'custom' ) {
			$marquee_content = isset( $options['custom_text'] ) ? esc_textarea( $options['custom_text'] ) : '';
		} elseif ( $source === 'posts' ) {
			$posts = get_posts( [ 'numberposts' => $posts_per_page ] );
			foreach ( $posts as $post ) {
				$marquee_content .= '<li><a href="' . get_permalink( $post->ID ) . '">' . esc_html( $post->post_title ) . '</a></li>';
			}
		} elseif ( $source === 'page' ) {
			$pages = get_pages( [ 'number' => $posts_per_page ] );
			foreach ( $pages as $page ) {
				$marquee_content .= '<li><a href="' . get_permalink( $page->ID ) . '">' . esc_html( $page->post_title ) . '</a></li>';
			}
		}

		echo '<div class="mk-marquee" ' .
			'data-mk-marquee-bg-color="' . esc_attr( $bg_color ) . '" ' .
			'data-mk-marquee-text-color="' . esc_attr( $text_color ) . '" ' .
			'data-mk-marquee-font-size="' . esc_attr( $font_size ) . '" ' .
			'data-mk-marquee-speed="' . esc_attr( $speed ) . '" ' .
			'data-mk-marquee-height="' . esc_attr( $height ) . '" ' .
			'data-mk-marquee-position="' . esc_attr( $position ) . '" ' .
			'data-mk-marquee-hover-pause="' . esc_attr( $hover_pause ) . '" ' .
			'data-mk-marquee-mobile="' . esc_attr( $disable_on_mobile ) . '">' .

			'<div class="mk-marquee__wrapper">' .
			'<ul class="mk-marquee__content">' .
			'<li>' . wp_kses_post( $marquee_content ) . '</li>' .
			'</ul>' .
			'</div>' .
			'</div>';
	}
}
