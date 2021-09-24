<a href="<?php echo get_the_permalink(); ?>">
	<div class="archive-box">
		<h5><?php the_excerpt(); ?></h5>
		<?php the_post_thumbnail('full'); ?>
		<h2><?php the_title(); ?></h2>
	</div>
</a>