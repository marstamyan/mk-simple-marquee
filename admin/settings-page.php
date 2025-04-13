<?php
function mk_simple_marquee_settings_page() {
	?>
	<div class="wrap">
		<h1>MK Simple Marquee Settings</h1>

		<form method="post" action="options.php">
			<?php
			wp_nonce_field( 'mk_simple_marquee_save_settings', 'mk_simple_marquee_nonce' );
			settings_fields( 'mk_simple_marquee_settings' );
			do_settings_sections( 'mk-simple-marquee' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function mk_simple_marquee_add_settings() {
	register_setting( 'mk_simple_marquee_settings', 'mk_simple_marquee_options' );

	add_settings_section(
		'mk_simple_marquee_general_section',
		'General Settings',
		null,
		'mk-simple-marquee'
	);

	add_settings_field(
		'mk_simple_marquee_enable',
		'Enable Marquee',
		'mk_simple_marquee_enable_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_bg_color',
		'Background Color',
		'mk_simple_marquee_bg_color_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_text_color',
		'Text Color',
		'mk_simple_marquee_text_color_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_font_size',
		'Font Size',
		'mk_simple_marquee_font_size_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_speed',
		'Speed',
		'mk_simple_marquee_speed_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_height',
		'Height',
		'mk_simple_marquee_height_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_position',
		'Position',
		'mk_simple_marquee_position_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_disable_on_mobile',
		'Show on Mobile',
		'mk_simple_marquee_disable_on_mobile_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_hover_pause',
		'Disable Pause on Hover',
		'mk_simple_marquee_hover_pause_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);

	add_settings_field(
		'mk_simple_marquee_source',
		'Source of Marquee Data',
		'mk_simple_marquee_source_callback',
		'mk-simple-marquee',
		'mk_simple_marquee_general_section'
	);
}

add_action( 'admin_init', 'mk_simple_marquee_add_settings' );

function mk_simple_marquee_enable_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<input type="checkbox" name="mk_simple_marquee_options[enable]" value="1" <?php checked( 1, isset( $options['enable'] ) ? $options['enable'] : 0 ); ?> />
	<?php
}

function mk_simple_marquee_bg_color_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<input type="text" name="mk_simple_marquee_options[bg_color]"
		value="<?php echo isset( $options['bg_color'] ) ? esc_attr( $options['bg_color'] ) : '#000000'; ?>"
		class="mk-marquee-color-picker" data-default-color="#000000" />
	<?php
}

function mk_simple_marquee_text_color_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<input type="text" name="mk_simple_marquee_options[text_color]"
		value="<?php echo isset( $options['text_color'] ) ? esc_attr( $options['text_color'] ) : '#ffffff'; ?>"
		class="mk-marquee-color-picker" data-default-color="#ffffff" />
	<?php
}

function mk_simple_marquee_font_size_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<select name="mk_simple_marquee_options[font_size]">
		<?php
		for ( $i = 16; $i <= 46; $i++ ) {
			echo '<option value="' . $i . 'px" ' . selected( $i . 'px', isset( $options['font_size'] ) ? $options['font_size'] : '16px', false ) . '>' . $i . 'px</option>';
		}
		?>
	</select>
	<?php
}

function mk_simple_marquee_speed_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<select name="mk_simple_marquee_options[speed]">
		<?php
		for ( $i = 100; $i <= 600; $i += 100 ) {
			echo '<option value="' . $i . '" ' . selected( $i, isset( $options['speed'] ) ? $options['speed'] : '40', false ) . '>' . $i . '</option>';
		}
		?>
	</select>
	<?php
}

function mk_simple_marquee_height_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<input type="number" name="mk_simple_marquee_options[height]"
		value="<?php echo isset( $options['height'] ) ? esc_attr( $options['height'] ) : 40; ?>" min="10" max="300" />
	<?php
}

function mk_simple_marquee_position_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<select name="mk_simple_marquee_options[position]">
		<option value="top" <?php selected( 'top', isset( $options['position'] ) ? $options['position'] : 'bottom' ); ?>>Top
		</option>
		<option value="bottom" <?php selected( 'bottom', isset( $options['position'] ) ? $options['position'] : 'bottom' ); ?>>
			Bottom</option>
	</select>
	<?php
}

function mk_simple_marquee_disable_on_mobile_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<input type="checkbox" name="mk_simple_marquee_options[disable_on_mobile]" value="1" <?php checked( 1, isset( $options['disable_on_mobile'] ) ? $options['disable_on_mobile'] : 0 ); ?> />
	<?php
}

function mk_simple_marquee_hover_pause_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	?>
	<input type="checkbox" name="mk_simple_marquee_options[hover_pause]" value="1" <?php checked( 1, isset( $options['hover_pause'] ) ? $options['hover_pause'] : 0 ); ?> />
	<?php
}

function mk_simple_marquee_source_callback() {
	$options = get_option( 'mk_simple_marquee_options' );
	$source = isset( $options['source'] ) ? $options['source'] : 'posts';
	?>
	<select name="mk_simple_marquee_options[source]" id="mk_simple_marquee_source">
		<option value="custom" <?php selected( $source, 'custom' ); ?>>Custom Text</option>
		<option value="posts" <?php selected( $source, 'posts' ); ?>>Posts</option>
		<option value="page" <?php selected( $source, 'page' ); ?>>Pages</option>
	</select>

	<?php if ( in_array( $source, [ 'posts', 'page' ] ) ) : ?>
		<p class="description" style="margin-top: 8px;">
			When "Pages" or "Posts" is selected, the number of items displayed will <br> follow the value set in
			<a href="<?php echo admin_url( 'options-reading.php' ); ?>" target="_blank">Reading Settings</a>
			under "Blog pages show at most".
		</p>
	<?php endif; ?>

	<div id="mk_simple_marquee_custom_text_container"
		style="display: <?php echo ( $source === 'custom' ) ? 'block' : 'none'; ?>;">
		<textarea name="mk_simple_marquee_options[custom_text]" rows="5" cols="50"
			style="margin-top:10px;"><?php echo isset( $options['custom_text'] ) ? esc_textarea( $options['custom_text'] ) : ''; ?></textarea>
	</div>
	<?php
}

function mk_simple_marquee_admin_scripts( $hook ) {
	if ( $hook !== 'settings_page_mk-simple-marquee' ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'mk-simple-marquee-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'mk_simple_marquee_admin_scripts' );


