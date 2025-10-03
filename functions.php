<?php
/**
 * Minivan functions and definitions
 *
 * @package Minivan
 */

// Disable direct access.
defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
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
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'minivan', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_script( 'minivan', get_template_directory_uri() . '/script.js', array(), wp_get_theme()->get( 'Version' ), true );
	}
);

register_nav_menus(
	array(
		'primary' => __( 'Primary Menu', 'minivan' ),
	)
);
