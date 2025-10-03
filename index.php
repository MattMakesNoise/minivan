<?php
/**
 * Main index template for displaying posts.
 *
 * @package Minivan
 */

get_header(); ?>

<?php if ( have_posts() ) : ?> 
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
			<article <?php post_class(); ?>>
				<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="meta"><?php echo get_the_date(); ?> · <?php the_author_posts_link(); ?></div>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'large' );
				}
				?>
				<div class="entry"><?php the_excerpt(); ?></div>
			</article>
			<hr>
<?php endwhile; else : ?>
	<p>No posts yet.</p>
<?php endif; ?>
<div class="pagination">
	<?php posts_nav_link( ' · ', 'Newer', 'Older' ); ?>
</div>
<?php get_footer(); ?>
