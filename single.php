<?php
/**
 * The template for displaying all single posts
 *
 * @package Minivan
 */

get_header(); ?>

<article <?php post_class(); ?>>
	<h1 class="post-title"><?php the_title(); ?></h1>
	<div class="meta">
		<?php echo get_the_date() . '·' . the_category( ', ' ); ?>
	</div>
	<?php
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'large' );
	}
	?>
	<div class="entry">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
				<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
</article>
<?php comments_template(); ?>
<?php get_footer(); ?>