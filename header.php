<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Minivan
 */

defined( 'ABSPATH' ) || exit; ?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header class="site-header">
		<div class="wrapper">
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			<nav>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		</div>
	</header>
<main class="wrapper">