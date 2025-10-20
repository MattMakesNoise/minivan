<?php
/**
 * Minivan functions and definitions
 *
 * @package Minivan
 */

// Disable direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Add theme support features.
 *
 * @return void
 */
function minivan_supports() {
	add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			),
		);
}
add_action( 'after_setup_theme', 'minivan_supports' );

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function minivan_enqueue_scripts_and_styles() {
	wp_enqueue_style( 'minivan', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'minivan', get_template_directory_uri() . '/script.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'minivan_enqueue_scripts_and_styles' );

/**
 * Register navigation menus.
 *
 * @return void
 */
function minivan_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'minivan' ),
		)
	);
}
add_action( 'init', 'minivan_register_menus' );

/**
 * Disable emojis (front + editor).
 *
 * @return void
 */
function minivan_disable_emojis() {
	// Front-end & admin emoji scripts/styles.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Feeds, emails, etc.
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// TinyMCE emoji plugin.
	add_filter(
		'tiny_mce_plugins',
		function ( $plugins ) {
			return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
		}
	);
}
add_action( 'init', 'minivan_disable_emojis' );

/**
 * Remove jQuery/jQuery-migrate on the front end.
 *
 * @param WP_Scripts $scripts The WP_Scripts instance.
 * @return void
 */
function minivan_remove_jquery_migrate( $scripts ) {
	if ( is_admin() ) {
		return;
	}

	if ( isset( $scripts->registered['jquery'] ) ) {
		// Remove jquery-migrate dependency from jquery.
		$deps = $scripts->registered['jquery']->deps;

		$scripts->registered['jquery']->deps = array_diff( $deps, array( 'jquery-migrate' ) );
	}
}
add_action( 'wp_default_scripts', 'minivan_remove_jquery_migrate' );

/**
 * Fully remove jQuery and jQuery-migrate on the front end if not needed.
 *
 * @return void
 */
function minivan_remove_jquery() {
	if ( is_admin() ) {
		return;
	}
	// Fully dequeue if nothing needs jQuery on the front.
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
	wp_dequeue_script( 'jquery-migrate' );
	wp_deregister_script( 'jquery-migrate' );
}
add_action( 'wp_enqueue_scripts', 'minivan_remove_jquery', 100 );

/**
 * Remove oEmbed + wp-embed (old embed support script).
 *
 * @return void
 */
function minivan_remove_oembed_wp_embed() {
	// REST oEmbed endpoint + discovery.
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	// Remove the tiny embed helper script.
	add_action(
		'wp_footer',
		function () {
			wp_dequeue_script( 'wp-embed' );
		},
		1
	);
}
add_action( 'init', 'minivan_remove_oembed_wp_embed' );

/**
 * Trim <head> noise.
 *
 * @return void
 */
function minivan_trim_head_noise() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
}
add_action( 'init', 'minivan_trim_head_noise' );

/**
 * Remove global block styles on the front.
 *
 * @return void
 */
function minivan_remove_global_block_styles() {
	if ( is_admin() ) {
		return;
	}
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wp-duotone' );
}
add_action( 'wp_enqueue_scripts', 'minivan_remove_global_block_styles', 20 );

/**
 * Don’t load Dashicons for visitors (still loads for logged-in users).
 *
 * @return void
 */
function minivan_remove_dashicons() {
	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'minivan_remove_dashicons', 20 );

/**
 * Only load comment-reply if needed.
 *
 * @return void
 */
function minivan_remove_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	} else {
		wp_dequeue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'minivan_remove_comment_reply', 20 );
