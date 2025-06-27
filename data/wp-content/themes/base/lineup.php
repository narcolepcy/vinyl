<?php get_header(); ?>
<?php
	$args = array(
		'post_type' => 'news',
		'posts_per_page' => 10, //最新何件表示するか
		'orderby' => 'date',
		'order' => 'DESC',
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>                
	<ul>                    
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>                                     
			<li>
				<?= the_time('Y.m.d'); ?>
				<?= the_title(); ?>
			</li>				
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?> 
	</ul>                                   
<?php endif; ?>
<?php get_footer(); ?>
